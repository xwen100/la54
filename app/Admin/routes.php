<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', "UsersController");
    $router->resource('article', "ArticleController");
    $router->resource('cat', "CatController");
    $router->resource('album', "AlbumController");
    $router->get('album/get/{id}', 'AlbumController@getAlbumImage');
    $router->post('album/save', 'AlbumController@save');
    $router->put('album/update', 'AlbumController@update');
    $router->get('image/{albumId}', "ImageController@index");
    $router->get('image/{albumId}/create', "ImageController@create");
    $router->post('image/save', "ImageController@save");
    $router->get('image/get/{id}', 'ImageController@getImage');
    $router->get('image/{id}/edit', 'ImageController@edit');
    $router->post('image/update/{id}', 'ImageController@update');
    $router->get('image/destroy/{id}', 'ImageController@destroy');
    $router->get('image/{id}/set', 'ImageController@set');

    $router->resource('goods/cat', 'GoodsCatController');
    $router->resource('goods', 'GoodsController');
    
});
