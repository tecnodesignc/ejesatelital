<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/polls/v1'], function (Router $router) {
 require ('ApiRoutes/pollRoutes.php');
 require ('ApiRoutes/questionRoutes.php');
 require ('ApiRoutes/answerRoutes.php');
 require ('ApiRoutes/resultRoutes.php');
    require ('ApiRoutes/typeRoutes.php');
});
