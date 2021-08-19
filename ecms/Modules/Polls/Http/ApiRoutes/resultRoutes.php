<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/results'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.polls.result.create',
        'uses' => 'ResultApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.polls.result.get.items.by',
        'uses' => 'ResultApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.polls.result.get.item',
        'uses' => 'ResultApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.polls.result.update',
        'uses' => 'ResultApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.polls.result.delete',
        'uses' => 'ResultApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
