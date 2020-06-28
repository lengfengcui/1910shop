<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

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

           //将token存储到redis中
            Redis::set($token,$user->user_id);
            //设置key的过期时间
            //Redis::expire($token,10);
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

        if(isset($_GET['token'])){
            $token = $_GET['token'];
        }else{
            $response = [
                'errno' => 50007,
                'msg'   => '请先登录',
            ];
            return $response;
        }

        //检查token是否有效
        $uid = Redis::get($token);
        if($uid)
        {
            $user_info = UserModel::find($uid);
            //已登录
            echo $user_info->user_name . " 欢迎来到个人中心";
        }else{
            //未登录
            $response = [
                'errno' => 50008,
                'msg'   => '请先登录',
            ];
            return $response;
        }
    }
    //订单
    public function orders(){
        //鉴权
        if(isset($_GET['token'])){
            $token = $_GET['token'];
            //验证token有效
            $uid = Redis::get($token);
            if($uid){

            }else{
                $response = [
                    'errno' => 50008,
                    'msg'   => '请先登录',
                ];
                return $response;
            }
        }else{
            $response = [
                'errno' => 50007,
                'msg'   => '请先登录',
            ];
            return $response;
        }

        //订单信息
        $arr=[
            '0347304893488038337',
            '0334304893488038337',
            '0356304893488038337',
            '0387304893488038337',
            '0334304893488038337',
        ];
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'=>[
                'orders'=>$arr
            ]
        ];
        return $response;
    }
    //购物车
    public function cart(){
        if(!isset($_GET['token'])){
            $response = [
                'errno' => 50007,
                'msg'   => '请先登录',
            ];
            return $response;
        }
        //鉴权
        $token = $_GET['token'];
        //验证token有效
        $uid = Redis::get($token);
        if($uid){

        }else{
            $response = [
                'errno' => 50008,
                'msg'   => '请先登录',
            ];
            return $response;
        }

        $goods=[
          123,
          456,
          789
        ];
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'=>$goods
        ];
        return $response;
    }
}
