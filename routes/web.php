<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    echo "api";
    //return view('welcome');
});

Route::get('/info',function(){
    phpinfo();
});

Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');
Route::get('/test/test1','TestController@test1');
Route::get('/test/sign1','TestController@sign1');
Route::get('secret','TestController@secret');
//商品
Route::get('/goods/detail','Goods\GoodsController@detail');//商品详情
//用户注册
Route::get('/user/reg','User\IndexController@reg');
Route::post('/user/reg','User\IndexController@regdo');
//用户登录
Route::get('/user/login','User\IndexController@login');
Route::post('/user/login','User\IndexController@logindo');
//个人中心
Route::get('/user/center','User\IndexController@center');
//接口开发
Route::post('/api/user/reg','Api\UserController@reg');//注册
Route::post('/api/user/login','Api\UserController@login');//登录
Route::get('/api/user/center','Api\UserController@center')->middleware('check.pri');//个人中心
Route::get('/api/user/orders','Api\UserController@orders')->middleware('check.pri');//订单
Route::get('/api/user/cart','Api\UserController@cart')->middleware('check.pri');//购物车
Route::get('/api/a','Api\TestController@a')->middleware('check.pri','access.filter');
Route::get('/api/b','Api\TestController@b')->middleware('check.pri','access.filter');
Route::get('/api/c','Api\TestController@c')->middleware('check.pri','access.filter');
//路由分组
Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/x','Api\TestController@x');
    Route::get('/api/y','Api\TestController@y');
    Route::get('/api/z','Api\TestController@z');
});
