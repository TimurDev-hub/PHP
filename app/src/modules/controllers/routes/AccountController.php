<?php

namespace Controllers\Routes;

use Controllers\Utils\HeaderController;
use Controllers\Services\{RegistrationService, LoginService};

class AccountController
{
	private static function checkSession(): void
	{
		if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
			header('location: /profile');
			exit;
		}
	}

	private static function authServices(array $userData): ?array
	{
		if (isset($_POST['process']) && $_POST['process'] === 'login') {
			return [
				'login' => LoginService::processLogin(userData: $userData)
			];
		}

		if (isset($_POST['process']) && $_POST['process'] === 'registration') {
			return [
				'registration' => RegistrationService::processRegistration(userData: $userData)
			];
		}

		return null;
	}

	public function requireView(): void
	{
		self::checkSession();

		$authStatus = self::authServices(userData: $_POST);

		$navbarLinks = HeaderController::requireNavbar();

		require_once(__DIR__ . '/../../views/templates/account.image.php');
	}
}
