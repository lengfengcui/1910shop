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
    return view('welcome');
});

Route::get('/info',function(){
    phpinfo();
});

Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');
Route::get('/test/test1','TestController@test1');
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
