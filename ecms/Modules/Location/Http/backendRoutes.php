<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/location'], function (Router $router) {
    $router->bind('country', function ($id) {
        return app('Modules\Location\Repositories\CountryRepository')->find($id);
    });
    $router->get('countries', [
        'as' => 'admin.location.country.index',
        'uses' => 'CountryController@index',
        'middleware' => 'can:location.countries.index'
    ]);
    $router->get('countries/create', [
        'as' => 'admin.location.country.create',
        'uses' => 'CountryController@create',
        'middleware' => 'can:location.countries.create'
    ]);
    $router->post('countries', [
        'as' => 'admin.location.country.store',
        'uses' => 'CountryController@store',
        'middleware' => 'can:location.countries.create'
    ]);
    $router->get('countries/{country}/edit', [
        'as' => 'admin.location.country.edit',
        'uses' => 'CountryController@edit',
        'middleware' => 'can:location.countries.edit'
    ]);
    $router->put('countries/{country}', [
        'as' => 'admin.location.country.update',
        'uses' => 'CountryController@update',
        'middleware' => 'can:location.countries.edit'
    ]);
    $router->delete('countries/{country}', [
        'as' => 'admin.location.country.destroy',
        'uses' => 'CountryController@destroy',
        'middleware' => 'can:location.countries.destroy'
    ]);
    $router->bind('province', function ($id) {
        return app('Modules\Location\Repositories\ProvinceRepository')->find($id);
    });
    $router->get('provinces', [
        'as' => 'admin.location.province.index',
        'uses' => 'ProvinceController@index',
        'middleware' => 'can:location.provinces.index'
    ]);
    $router->get('provinces/create', [
        'as' => 'admin.location.province.create',
        'uses' => 'ProvinceController@create',
        'middleware' => 'can:location.provinces.create'
    ]);
    $router->post('provinces', [
        'as' => 'admin.location.province.store',
        'uses' => 'ProvinceController@store',
        'middleware' => 'can:location.provinces.create'
    ]);
    $router->get('provinces/{province}/edit', [
        'as' => 'admin.location.province.edit',
        'uses' => 'ProvinceController@edit',
        'middleware' => 'can:location.provinces.edit'
    ]);
    $router->put('provinces/{province}', [
        'as' => 'admin.location.province.update',
        'uses' => 'ProvinceController@update',
        'middleware' => 'can:location.provinces.edit'
    ]);
    $router->delete('provinces/{province}', [
        'as' => 'admin.location.province.destroy',
        'uses' => 'ProvinceController@destroy',
        'middleware' => 'can:location.provinces.destroy'
    ]);
    $router->bind('city', function ($id) {
        return app('Modules\Location\Repositories\CityRepository')->find($id);
    });
    $router->get('cities', [
        'as' => 'admin.location.city.index',
        'uses' => 'CityController@index',
        'middleware' => 'can:location.cities.index'
    ]);
    $router->get('cities/create', [
        'as' => 'admin.location.city.create',
        'uses' => 'CityController@create',
        'middleware' => 'can:location.cities.create'
    ]);
    $router->post('cities', [
        'as' => 'admin.location.city.store',
        'uses' => 'CityController@store',
        'middleware' => 'can:location.cities.create'
    ]);
    $router->get('cities/{city}/edit', [
        'as' => 'admin.location.city.edit',
        'uses' => 'CityController@edit',
        'middleware' => 'can:location.cities.edit'
    ]);
    $router->put('cities/{city}', [
        'as' => 'admin.location.city.update',
        'uses' => 'CityController@update',
        'middleware' => 'can:location.cities.edit'
    ]);
    $router->delete('cities/{city}', [
        'as' => 'admin.location.city.destroy',
        'uses' => 'CityController@destroy',
        'middleware' => 'can:location.cities.destroy'
    ]);
    $router->bind('polygon', function ($id) {
        return app('Modules\Location\Repositories\PolygonRepository')->find($id);
    });
    $router->get('polygons', [
        'as' => 'admin.location.polygon.index',
        'uses' => 'PolygonController@index',
        'middleware' => 'can:location.polygons.index'
    ]);
    $router->get('polygons/create', [
        'as' => 'admin.location.polygon.create',
        'uses' => 'PolygonController@create',
        'middleware' => 'can:location.polygons.create'
    ]);
    $router->post('polygons', [
        'as' => 'admin.location.polygon.store',
        'uses' => 'PolygonController@store',
        'middleware' => 'can:location.polygons.create'
    ]);
    $router->get('polygons/{polygon}/edit', [
        'as' => 'admin.location.polygon.edit',
        'uses' => 'PolygonController@edit',
        'middleware' => 'can:location.polygons.edit'
    ]);
    $router->put('polygons/{polygon}', [
        'as' => 'admin.location.polygon.update',
        'uses' => 'PolygonController@update',
        'middleware' => 'can:location.polygons.edit'
    ]);
    $router->delete('polygons/{polygon}', [
        'as' => 'admin.location.polygon.destroy',
        'uses' => 'PolygonController@destroy',
        'middleware' => 'can:location.polygons.destroy'
    ]);
    $router->bind('neighborhood', function ($id) {
        return app('Modules\Location\Repositories\NeighborhoodRepository')->find($id);
    });
    $router->get('neighborhoods', [
        'as' => 'admin.location.neighborhood.index',
        'uses' => 'NeighborhoodController@index',
        'middleware' => 'can:location.neighborhoods.index'
    ]);
    $router->get('neighborhoods/create', [
        'as' => 'admin.location.neighborhood.create',
        'uses' => 'NeighborhoodController@create',
        'middleware' => 'can:location.neighborhoods.create'
    ]);
    $router->post('neighborhoods', [
        'as' => 'admin.location.neighborhood.store',
        'uses' => 'NeighborhoodController@store',
        'middleware' => 'can:location.neighborhoods.create'
    ]);
    $router->get('neighborhoods/{neighborhood}/edit', [
        'as' => 'admin.location.neighborhood.edit',
        'uses' => 'NeighborhoodController@edit',
        'middleware' => 'can:location.neighborhoods.edit'
    ]);
    $router->put('neighborhoods/{neighborhood}', [
        'as' => 'admin.location.neighborhood.update',
        'uses' => 'NeighborhoodController@update',
        'middleware' => 'can:location.neighborhoods.edit'
    ]);
    $router->delete('neighborhoods/{neighborhood}', [
        'as' => 'admin.location.neighborhood.destroy',
        'uses' => 'NeighborhoodController@destroy',
        'middleware' => 'can:location.neighborhoods.destroy'
    ]);
// append





});
