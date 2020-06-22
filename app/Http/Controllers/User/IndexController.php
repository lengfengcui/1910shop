<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class IndexController extends Controller
{
    public function reg(){
        return view("user.reg");
    }
    public function regdo(Request $request){
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $name=$request->input('name');
        $email=$request->input('email');

        //密码长度是否大于6位
        $len=strlen($pass1);
        if($len<6){
            die("密码长度必须大于6位");
        }

        //两次密码是否一致
        if($pass1 != $pass2){
            die("两次输入密码不一致");
        }
        //检查用户是否已存在
        $user=UserModel::where(['user_name'=>$name])->first();
        if($user){
            die("用户名已存在");
        }

        //检查email是否已存在
        $user=UserModel::where(['email'=>$email])->first();
        if($user){
            die("email已存在");
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
            header('Refresh:1;url=/user/login');
            echo "注册成功";
        }else{
            header('Refresh:1;url=/user/reg');
            echo "注册失败";
        }
    }

    public function login(){
        return view("user.login");
    }
    public function logindo(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        //验证登录信息
        $user=UserModel::where(['user_name'=>$name])->first();
        //验证密码
        $res=password_verify($pass,$user->password);
        if($res){
            header('Refresh:1;url=/user/center');
            echo "登录成功";
        }else{
            header('Refresh:1;url=/user/login');
            echo "用户与密码不一致";
        }
    }
    public function center(){
        return view("user.center");
    }
}
