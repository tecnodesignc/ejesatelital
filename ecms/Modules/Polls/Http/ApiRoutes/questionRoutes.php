<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/questions'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.polls.question.create',
        'uses' => 'QuestionApiController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.polls.question.get.items.by',
        'uses' => 'QuestionApiController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.polls.question.get.item',
        'uses' => 'QuestionApiController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.polls.question.update',
        'uses' => 'QuestionApiController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.polls.question.delete',
        'uses' => 'QuestionApiController@delete',
        'middleware' => ['auth:api']
    ]);
});
