<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\TokenModel;

class UserController extends Controller
{

    public function reg(Request $request){
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $name=$request->input('name');
        $email=$request->input('email');

        //密码长度是否大于6位
        $len=strlen($pass1);
        if($len<6){
            $response=[
                'error'=>50001,
                'msg'=>'密码长度必须大于6位'
            ];
            return $response;
        }

        //两次密码是否一致
        if($pass1 != $pass2){
            $response=[
                'error'=>50002,
                'msg'=>'两次输入密码不一致'
            ];
            return $response;
        }
        //检查用户是否已存在
        $user=UserModel::where(['user_name'=>$name])->first();
        if($user){
            $response=[
                'error'=>50003,
                'msg'=>'用户名已存在'
            ];
            return $response;
        }

        //检查email是否已存在
        $user=UserModel::where(['email'=>$email])->first();
        if($user){
            $response=[
                'error'=>50004,
                'msg'=>'email已存在'
            ];
            return $response;
        }
        //生成密码
        $pass=password_hash($pass1,PASSWORD_BCRYPT);

        //验证通过 生成用户记录
        $data=[
            'user_name'=>$name,
            'email'=>$email,
            'password'=>$pass,
            'reg_time'=>time()
        ];
        $res=UserModel::insert($data);
        if($res){
            $response=[
                'error'=>0,
                'msg'=>'注册成功'
            ];
        }else{
            $response=[
                'error'=>50005,
                'msg'=>'注册失败'
            ];
        }
        return $response;
    }
    public function login(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        //验证登录信息
        $user=UserModel::where(['user_name'=>$name])->first();
        //验证密码
        $res=password_verify($pass,$user->password);
        if($res){
            //生成token
            $str=$user->user_id . $user->user_name . time();
            $token = substr(md5($str),10,16) . substr(md5($str),0,10);

            //保存token,后续验证使用
            $data = [
                'uid'   => $user->user_id,
                'token' => $token
            ];
            TokenModel::insert($data);

            $response = [
                'errno' => 0,
                'msg'   => 'ok',
                'token' => $token
            ];
        }else{
            $response = [
                'errno' => 50006,
                'msg'   => '用户名与密码不一致,请重新登录',
            ];
        }
        return $response;
    }
    public function center(){
        //判断用户是否登录 ,判断是否有 uid 字段
        $token = $_GET['token'];

        //检查token是否有效
        $res = TokenModel::where(['token'=>$token])->first();
        if($res)
        {
            $uid = $res->uid;
            $user_info = UserModel::find($uid);
            //已登录
            echo $user_info->user_name . " 欢迎来到个人中心";
        }else{
            //未登录
            echo "请登录";
        }
    }
}