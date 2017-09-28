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
	return redirect('/login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/read/{id}', 'HomeController@read');
Route::get('/album', 'AlbumController@index');
Route::get('/album/get/{id}', 'AlbumController@get');
Route::get('/image/{albumId}', 'ImageController@index');
Route::get('/image/get/{id}', 'ImageController@get');
Route::group(['middleware'=>'auth'], function(){
	
});


