<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/vehicle'], function (Router $router) {
    $router->bind('vehicle', function ($id) {
        return app('Modules\Vehicle\Repositories\VehicleRepository')->find($id);
    });
    $router->get('vehicles', [
        'as' => 'admin.vehicle.vehicle.index',
        'uses' => 'VehicleController@index',
        'middleware' => 'can:vehicle.vehicles.index'
    ]);
    $router->get('vehicles/create', [
        'as' => 'admin.vehicle.vehicle.create',
        'uses' => 'VehicleController@create',
        'middleware' => 'can:vehicle.vehicles.create'
    ]);
    $router->post('vehicles', [
        'as' => 'admin.vehicle.vehicle.store',
        'uses' => 'VehicleController@store',
        'middleware' => 'can:vehicle.vehicles.create'
    ]);
    $router->get('vehicles/{vehicle}/edit', [
        'as' => 'admin.vehicle.vehicle.edit',
        'uses' => 'VehicleController@edit',
        'middleware' => 'can:vehicle.vehicles.edit'
    ]);
    $router->put('vehicles/{vehicle}', [
        'as' => 'admin.vehicle.vehicle.update',
        'uses' => 'VehicleController@update',
        'middleware' => 'can:vehicle.vehicles.edit'
    ]);
    $router->delete('vehicles/{vehicle}', [
        'as' => 'admin.vehicle.vehicle.destroy',
        'uses' => 'VehicleController@destroy',
        'middleware' => 'can:vehicle.vehicles.destroy'
    ]);
// append

});
