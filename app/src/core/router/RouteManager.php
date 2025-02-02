<?php

namespace Core\Router;

use Helpers\ErrorsLogger;
use Config\Errors\{FileNotFound, RouteNotFound, MethodNotFound};
use Exception;
use Throwable;

class RouteManager
{
	private const CONTROLLER = 'routeController';
	private const METHOD = 'controllerMethod';

	private array $appRoutes;

	public function __construct(array $appRoutes)
	{
		$this->appRoutes = $appRoutes;
	}

	private function parseUri(string $requestUri): ?string
	{
		return parse_url(htmlspecialchars($requestUri), PHP_URL_PATH) ?? null;
	}

	private function findRoute(string $requestUri): ?array
	{
		return $this->appRoutes[$requestUri] ?? null;
	}

	private function dispatchRoute(array $routingTable): void
	{
		if (!class_exists($routingTable[self::CONTROLLER])) {
			throw new FileNotFound("Файл '{$routingTable[self::CONTROLLER]}' не найден");
		}

		$routeController = new $routingTable[self::CONTROLLER];
		$controllerMethod = $routingTable[self::METHOD];

		if (!method_exists($routeController, $controllerMethod)) {
			throw new MethodNotFound("Метод '{$controllerMethod}' не найден в контроллере '{$routingTable[self::CONTROLLER]}'");
		}

		$routeController?->$controllerMethod();
	}

	public function routerStarter(): void
	{
		try {
			$parsedUri = $this->parseUri(requestUri: $_SERVER['REQUEST_URI']);
			$appRoute = $this->findRoute(requestUri: $parsedUri);

			if ($appRoute === null) {
				throw new RouteNotFound("Маршрут '$parsedUri' не найден");
			}

			$this->dispatchRoute(routingTable: $appRoute);

		} catch (RouteNotFound $exc) {
			ErrorsLogger::handleError(exc: $exc);

		} catch (FileNotFound $exc) {
			ErrorsLogger::handleError(exc: $exc);

		} catch (MethodNotFound $exc) {
			ErrorsLogger::handleError(exc: $exc);
		
		} catch (Exception | Throwable $exc) {
			ErrorsLogger::handleError(exc: $exc);

		}
	}
}
