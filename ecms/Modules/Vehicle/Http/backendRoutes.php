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
    $router->bind('brand', function ($id) {
        return app('Modules\Vehicle\Repositories\BrandRepository')->find($id);
    });
    $router->get('brands', [
        'as' => 'admin.vehicle.brand.index',
        'uses' => 'BrandController@index',
        'middleware' => 'can:vehicle.brands.index'
    ]);
    $router->get('brands/create', [
        'as' => 'admin.vehicle.brand.create',
        'uses' => 'BrandController@create',
        'middleware' => 'can:vehicle.brands.create'
    ]);
    $router->post('brands', [
        'as' => 'admin.vehicle.brand.store',
        'uses' => 'BrandController@store',
        'middleware' => 'can:vehicle.brands.create'
    ]);
    $router->get('brands/{brand}/edit', [
        'as' => 'admin.vehicle.brand.edit',
        'uses' => 'BrandController@edit',
        'middleware' => 'can:vehicle.brands.edit'
    ]);
    $router->put('brands/{brand}', [
        'as' => 'admin.vehicle.brand.update',
        'uses' => 'BrandController@update',
        'middleware' => 'can:vehicle.brands.edit'
    ]);
    $router->delete('brands/{brand}', [
        'as' => 'admin.vehicle.brand.destroy',
        'uses' => 'BrandController@destroy',
        'middleware' => 'can:vehicle.brands.destroy'
    ]);
// append


});
