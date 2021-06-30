<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/gps'], function (Router $router) {
//Route index
    $router->get('/', [
        'as' => 'api.gps.list.index',
        'uses' => 'GpsApiController@index'
    ]);
});
