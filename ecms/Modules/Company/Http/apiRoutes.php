<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/company/v1'], function (Router $router) {
    require('ApiRoutes/accountApiRoutes.php');
    require('ApiRoutes/contactApiRoutes.php');
    require('ApiRoutes/accountTypeApiRoutes.php');
});
