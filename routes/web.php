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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/like', 'HomeController@addlike')->name('like');
Route::post('/comment', 'HomeController@comment')->name('comment');
Route::group(['middleware' => 'auth','prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::post('/addMessage', 'AdminController@addMessage')->name('addMessage');
    Route::get('/video', 'AdminController@video')->name('video');
    Route::post('/addVideo', 'AdminController@addVideo')->name('addVideo');
    Route::get('/videoList', 'AdminController@videoList')->name('videoList');
    Route::get('/bvideo', 'AdminController@bvideo')->name('bvideo');
    Route::get('/videoDel', 'AdminController@videoDel')->name('videoDel');
    Route::get('/getVideoUrl/{id}', 'AdminController@getVideoUrl')->name('getVideoUrl');
    Route::get('/test', 'AdminController@test')->name('test');

});

Route::group(['middleware' => 'auth','prefix'=>'user','namespace'=>'Admin'], function () {
    Route::get('/edit', 'UserController@edit')->name('userEdit');
    Route::post('/editUser', 'UserController@editUser')->name('editUser');
});





