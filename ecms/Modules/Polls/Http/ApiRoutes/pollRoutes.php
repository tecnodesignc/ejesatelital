<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/polls'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.polls.polls.create',
        'uses' => 'PollApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.polls.polls.get.items.by',
        'uses' => 'PollApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.polls.polls.get.item',
        'uses' => 'PollApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.polls.polls.update',
        'uses' => 'PollApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.polls.polls.delete',
        'uses' => 'PollApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
