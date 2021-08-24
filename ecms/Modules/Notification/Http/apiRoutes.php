<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('notification/mark-read', ['as' => 'api.notification.read', 'uses' => 'NotificationsController@markAsRead']);


$router->group(['prefix' =>'notification/v1/notifications'], function (Router $router) {
//Route create

    $router->post('/readAll', [
        'as' => 'api.notification.notification.read.all',
        'uses' => 'NotificationsController@marksAsRead',
        'middleware' => ['auth:api']
    ]);

    $router->post('/', [
        'as' => 'api.notification.notification.create',
        'uses' => 'NotificationsController@create',
        'middleware' => ['auth:api']
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.notification.notification.index',
        'uses' => 'NotificationsController@index',
        'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.notification.notification.show',
        'uses' => 'NotificationsController@show',
        'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.notification.notification.edit',
        'uses' => 'NotificationsController@update',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.notification.notification.destroy',
        'uses' => 'NotificationsController@delete',
        'middleware' => ['auth:api']
    ]);
});
