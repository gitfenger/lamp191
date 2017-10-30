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


Route::group(['middleware'=>['web']],function(){
    //前台路由
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
    Route::get('/a/{art_id}','Home\IndexController@article');


    Route::get('/admin/sendsms/{id}', 'Admin\LoginController@sendSMS');

    Route::get('/admin/login', 'Admin\LoginController@login');
    Route::post('admin/dologin', 'Admin\LoginController@dologin');
    Route::get('/crypt', 'Admin\LoginController@crypt');
    Route::get('/code', 'Admin\LoginController@code');
});








//Route::get('/getcode', 'Admin\LoginController@getcode');
//'middleware' => 'admin.login',
Route::group(['prefix'=>'admin','namespace'=>'Admin'], function () {
//后台首页
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');
    //文章分类路由
    Route::post('cate/changeorder', 'CategoryController@changeorder');
    Route::resource('category','CategoryController');

    //文章路由v
    Route::get('article/test','ArticleController@test');
    Route::resource('article','ArticleController');

    Route::any('upload','CommonController@upload');


    //友情链接路由
    Route::post('links/changeorder', 'LinksController@changeorder');
    Route::resource('links','LinksController');


    //导航路由
    Route::post('navs/changeorder', 'NavsController@changeorder');
    Route::resource('navs','NavsController');

    //网站配置路由
    Route::post('config/changeorder', 'configController@changeorder');
    Route::post('config/changecontent', 'configController@changeContent');
    Route::resource('config','configController');
});