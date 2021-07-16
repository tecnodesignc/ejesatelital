<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/brands'], function (Router $router) {

    //Route create
    $router->post('/', [
        'as' => 'api.vehicle.brand.create',
        'uses' => 'BrandApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.vehicle.brand.get.items.by',
        'uses' => 'BrandApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.vehicle.brand.get.item',
        'uses' => 'BrandApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.vehicle.brand.update',
        'uses' => 'BrandApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.vehicle.brand.delete',
        'uses' => 'BrandApiController@delete',
        'middleware' => ['auth:api']
    ]);



});
