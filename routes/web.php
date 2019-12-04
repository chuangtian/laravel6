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

});





