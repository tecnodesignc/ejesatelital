<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/contact'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.company.contact.create',
        'uses' => 'ContactApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.company.contact.index',
        'uses' => 'ContactApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.company.contact.show',
        'uses' => 'ContactApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.company.contact.update',
        'uses' => 'ContactApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.company.contact.delete',
        'uses' => 'ContactApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
