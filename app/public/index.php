<?php

session_start();

require_once(__DIR__ . '/../../vendor/autoload.php');

$router = new Core\Router\RouteManager(appRoutes: Core\Router\Routes::loadRoutingTable());

$router->routerStarter();
