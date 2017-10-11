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
Route::get('/shop/home', 'shop\HomeController@index');
Route::get('/shop/home/read/{id}', 'shop\HomeController@read');
Route::post('/shop/cart', 'shop\CartController@save');
Route::get('/shop/cart', 'shop\CartController@index');
Route::get('/shop/cart/{id}', 'shop\CartController@delete');
Route::post('/shop/cart/{id}', 'shop\CartController@update');
Route::get('/shop/order', 'shop\OrderController@add');
Route::get('/shop/order/act', 'shop\OrderController@act');
Route::post('/shop/order/act', 'shop\OrderController@ord1');
Route::get('/shop/pay', 'shop\OrderController@pay');
Route::get('/shop/register', 'shop\RegisterController@reg');
Route::post('/shop/register', 'shop\RegisterController@save');
Route::get('/shop/login', 'shop\LoginController@login');
Route::post('/shop/login', 'shop\LoginController@act');
Route::get('/shop/logout', 'shop\LoginController@logout');
Route::get('/shop/member', 'shop\MemberController@index');
Route::get('/shop/myorder', 'shop\MemberController@order');

Route::group(['middleware'=>'auth'], function(){
	
});


