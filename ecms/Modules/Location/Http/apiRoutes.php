<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => 'location/v1'], function (Router $router) {

    require('ApiRoutes/CityApiRoutes.php');
    require('ApiRoutes/CountryApiRoutes.php');
    require('ApiRoutes/ProvinceApiRoutes.php');
   /*require('ApiRoutes/PolygonApiRoutes.php');
    require ('ApiRoutes/NeighborhoodApiRoutes.php');*/


});
