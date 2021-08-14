<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/vehicle/v1'], function (Router $router) {
    require('ApiRoutes/brandApiRoutes.php');
    require('ApiRoutes/vehicleApiRoutes.php');
    require('ApiRoutes/typeApiRoutes.php');
});
