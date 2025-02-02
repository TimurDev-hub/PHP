<?php

namespace Controllers\Routes;

use Controllers\Utils\HeaderController;
use Controllers\Services\ProfileService;

class ProfileController
{
	private static function checkSession(): void
	{
		if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
			header('location: /default');
			exit;
		}

		if (isset($_POST['out'])) {
			unset($_SESSION['user'], $_SESSION['admin']);
			header('Location: /default');
			exit;
		}
	}

	private static function use_updateUserData(array $userData, mixed $userId): ?string
	{
		if (isset($_SESSION['user']) && isset($_POST['saveUserData'])) {
			return ProfileService::updateUserData(userData: $userData, userId: $userId);
		}

		return null;
	}

	private static function use_routesServices(array $cardData): ?array
	{
		if (isset($_SESSION['admin']) && isset($_POST['pushRoute'])) {
			return [
				'push' => ProfileService::pushNewRoute(cardData: $cardData)
			];
		}

		if (isset($_SESSION['admin']) && isset($_POST['routeId'])) {
			return [
				'route' => ProfileService::findRouteById(cardData: $cardData)
			];
		}

		if (isset($_SESSION['admin']) && isset($_POST['updateRoute'])) {
			return [
				'update' => ProfileService::updateRoute(cardData: $cardData)
			];
		}

		if (isset($_SESSION['admin']) && isset($_POST['deleteRoute'])) {
			return [
				'delete' => ProfileService::deleteRouteById(cardData: $cardData)
			];
		}

		return null;
	}

	private static function getUserParams(): array
	{
		return [
			'name' => htmlspecialchars($_SESSION['admin']['user_name'] ?? $_SESSION['user']['user_name']),
			'email' => htmlspecialchars($_SESSION['admin']['user_email'] ?? $_SESSION['user']['user_email'])
		];
	}

	public function requireView(): void
	{
		self::checkSession();

		$userId = $_SESSION['admin']['user_id'] ?? $_SESSION['user']['user_id'];

		$renameStatus = self::use_updateUserData(userData: $_POST, userId: $userId);
		$userData = self::getUserParams();

		$routeService = self::use_routesServices(cardData: $_POST);

		$navbarLinks = HeaderController::requireNavbar();

		require_once(__DIR__ . '/../../views/templates/profile.image.php');
	}
}
