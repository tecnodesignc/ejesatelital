<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/provinces'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.location.province.create',
        'uses' => 'ProvinceApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.location.province.index',
        'uses' => 'ProvinceApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.location.province.show',
        'uses' => 'ProvinceApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.location.province.edit',
        'uses' => 'ProvinceApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.location.province.destroy',
        'uses' => 'ProvinceApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
