<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    public function hello(){
        echo __METHOD__;echo "</br>";
        echo date('Y-m-d H:i:s');
    }
    //redis测试
    public function redis1(){
        $key="name1";
        $val1=Redis::get($key);
        var_dump($val1);
        echo '$val1:'.$val1;
    }
    public function test1(){
        $data=[
            'name'=>'zhangsan',
            'email'=>'zhangsan@qq.com'
        ];
        return $data;
    }
    //发送数据
    public function sign1(){
        $key='udsdjnsbaavv';
        $data='hello word';
        $sign=sha1($data.$key);//生成签名
        echo "要发送的数据：".$data;echo '</br>';
        echo "发送前生成的签名：".$sign;echo '<hr>';

        //将数据和签名发送到对端
        $b_url="http://www.1910.com/secret?data=".$data."&sign=".$sign;
        echo $b_url;
    }
    //接收数据
    public function secret(){
        $key='udsdjnsbaavv';
       echo '<pre>';print_r($_GET);echo '</pre>';
       $data=$_GET['data'];//接收到的数据
       $sign=$_GET['sign'];//接收到的签名
       $local_sign=sha1($data.$key);
       echo '本地计算的签名：'.$local_sign;echo '</br>';

       if($sign == $local_sign)
       {
           echo "验签通过";
       }else{
           echo "验签失败";
       }
    }
    public function www(){
        $key = '1910';
        $url = 'http://api.1910.com/api/info';      //接口地址

        //向接口发送数据
        //get方式发送
        $data = 'hello';
        $sign = sha1($data.$key);

        $url = $url . '?data='.$data.'&sign='.$sign;

        //php 发起网络请求
        $response = file_get_contents($url);
        echo $response;

    }
}
