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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/test', 'Api\ApiController@tes')->name('home');
});
Route::get('/tt', 'Api\ApiController@tt')->name('tt');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/like', 'HomeController@addlike')->name('like');
Route::post('/comment', 'HomeController@comment')->name('comment');
Route::get('/chat', 'HomeController@chat')->name('chat');
Route::group(['middleware' => 'auth','prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('/index', 'AdminController@index')->name('admin');
    Route::post('/addMessage', 'AdminController@addMessage')->name('addMessage');
    Route::get('/video', 'AdminController@video')->name('video');
    Route::post('/addVideo', 'AdminController@addVideo')->name('addVideo');
    Route::get('/videoList', 'AdminController@videoList')->name('videoList');
    Route::get('/bvideo', 'AdminController@bvideo')->name('bvideo');
    Route::get('/videoDel', 'AdminController@videoDel')->name('videoDel');
    Route::get('/getVideoUrl/{id}', 'AdminController@getVideoUrl')->name('getVideoUrl');
});

Route::group(['middleware' => 'auth','prefix'=>'user','namespace'=>'Admin'], function () {
    Route::get('/edit', 'UserController@edit')->name('userEdit');
    Route::post('/editUser', 'UserController@editUser')->name('editUser');
});


Route::group(['middleware' => 'auth','prefix'=>'chat','namespace'=>'Admin'], function () {
    Route::get('/index', 'ChatController@index')->name('chat');
});

//微信
Route::get('/w_login', 'WeixinController@w_login')->name('w_login');
Route::get('/w_login_info', 'WeixinController@w_login_info')->name('w_login_info');
Route::get('/w_getFriend', 'WeixinController@getFriend')->name('w_getFriend');
Route::get('/w_from', 'WeixinController@from')->name('w_from');
Route::get('/w_send', 'WeixinController@startSend')->name('w_send');
Route::post('/w_sendMessage', 'WeixinController@sendMessage')->name('w_sendMessage');




