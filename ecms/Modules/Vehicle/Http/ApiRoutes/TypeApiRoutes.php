<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/vehicle-type'], function (Router $router) {

    //Route index
    $router->get('/', [
        'as' => 'api.vehicle.type.get.items.by',
        'uses' => 'TypeApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.vehicle.type.get.item',
        'uses' => 'TypeApiController@show',
        'middleware' => ['auth:api']
    ]);
});
