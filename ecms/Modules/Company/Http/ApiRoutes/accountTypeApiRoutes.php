<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/account-type'], function (Router $router) {
//Route create
    $router->post('/', [
        'as' => 'api.company.accounttype.create',
        'uses' => 'AccountTypeApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.company.accounttype.index',
        'uses' => 'AccountTypeApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.company.accounttype.show',
        'uses' => 'AccountTypeApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.company.accounttype.update',
        'uses' => 'AccountTypeApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.company.accounttype.delete',
        'uses' => 'AccountTypeApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
