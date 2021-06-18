<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/account'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.company.account.create',
        'uses' => 'AccountApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.company.account.index',
        'uses' => 'AccountApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.company.account.show',
        'uses' => 'AccountApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.company.account.update',
        'uses' => 'AccountApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.company.account.delete',
        'uses' => 'AccountApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
