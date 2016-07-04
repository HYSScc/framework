<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$collection->add('homepage', new Route('/', [
    '_controller' => 'App\Controller\DefaultController::indexAction'
]));

$collection->add('login', new Route('/login', [
    '_controller' => 'App\Controller\DefaultController::loginAction'
]));

$collection->add('register', new Route('/register/{type}', [
    '_controller' => 'App\Controller\DefaultController::registerAction'
]));

return $collection;
