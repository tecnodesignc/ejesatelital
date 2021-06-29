<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/cities'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.location.city.create',
        'uses' => 'CityApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.location.city.index',
        'uses' => 'CityApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.location.city.show',
        'uses' => 'CityApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.location.city.edit',
        'uses' => 'CityApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.location.city.destroy',
        'uses' => 'CityApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
