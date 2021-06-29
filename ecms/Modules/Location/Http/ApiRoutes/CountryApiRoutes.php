<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/countries'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.location.country.create',
        'uses' => 'CountryApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.location.country.index',
        'uses' => 'CountryApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.location.country.show',
        'uses' => 'CountryApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.location.country.edit',
        'uses' => 'CountryApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.location.country.destroy',
        'uses' => 'CountryApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
