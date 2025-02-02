<?php

namespace Core\Router;

class Routes
{
	public static function loadRoutingTable(): array
	{
		$routingTable = [
			'/' => [
				'routeController' => 'Controllers\Routes\DefaultController',
				'controllerMethod' => 'requireView'
			],
			'/default' => [
				'routeController' => 'Controllers\Routes\DefaultController',
				'controllerMethod' => 'requireView'
			],
			'/account' => [
				'routeController' => 'Controllers\Routes\AccountController',
				'controllerMethod' => 'requireView'
			],
			'/profile' => [
				'routeController' => 'Controllers\Routes\ProfileController',
				'controllerMethod' => 'requireView'
			],
			'/error' => [
				'routeController' => 'Controllers\Routes\ErrorController',
				'controllerMethod' => 'requireView'
			]
		];

		return $routingTable;
	}
}
