<?php

use Src\Controllers\QuizController;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('index', new Routing\Route('/', array(
    '_controller' => [QuizController::class, 'indexAction']
)));

$routes->add('testLeap', new Routing\Route('leap/{year}', array(
    'year' => null,
    '_controller' => [QuizController::class, 'testAction']
)));

return $routes;