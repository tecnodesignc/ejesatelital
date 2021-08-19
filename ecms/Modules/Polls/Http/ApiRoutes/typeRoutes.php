<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/question-types'], function (Router $router) {

     //Route index
    $router->get('/', [
        'as' => 'api.polls.type.get.items.by',
        'uses' => 'TypeApiController@index',
        'middleware' => ['auth:api']
    ]);

   /* //Route show
    $router->get('/{criteria}', [
        'as' => 'api.polls.type.get.item',
        'uses' => 'TypeApiController@show',
        'middleware' => ['auth:api']
    ]);*/

});
