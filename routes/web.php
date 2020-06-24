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
//用户中心
Route::get('/user/center','User\IndexController@center');
//接口开发
Route::post('/api/user/reg','Api\UserController@reg');//注册
