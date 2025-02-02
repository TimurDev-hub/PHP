<?php

namespace Controllers\Routes;

use Controllers\Utils\HeaderController;

class ErrorController
{
	private static function includeError(): ?string
	{
		if (isset($_SESSION['routesError'])) {
			$error = $_SESSION['routesError'];
			unset($_SESSION['routesError']);
			return $error;
		} else {
			header('location: /default');
			exit;
		}
	}

	public function requireView(): void
	{
		$error = self::includeError();

		$navbarLinks = HeaderController::requireNavbar();

		require_once(__DIR__ . '/../../views/templates/error.image.php');
	}
}
