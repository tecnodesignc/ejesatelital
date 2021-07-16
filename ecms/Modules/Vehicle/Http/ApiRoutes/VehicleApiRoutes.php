<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/vehicle'], function (Router $router) {

    //Route create
    $router->post('/', [
        'as' => 'api.vehicle.vehicle.create',
        'uses' => 'VehicleApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.vehicle.vehicle.get.items.by',
        'uses' => 'VehicleApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.vehicle.vehicle.get.item',
        'uses' => 'VehicleApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.vehicle.vehicle.update',
        'uses' => 'VehicleApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.vehicle.vehicle.delete',
        'uses' => 'VehicleApiController@delete',
        'middleware' => ['auth:api']
    ]);



});
