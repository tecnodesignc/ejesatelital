<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/answers'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.polls.answer.create',
        'uses' => 'AnswerApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.polls.answer.get.items.by',
        'uses' => 'AnswerApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.polls.answer.get.item',
        'uses' => 'AnswerApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.polls.answer.update',
        'uses' => 'AnswerApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.polls.answer.delete',
        'uses' => 'AnswerApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
