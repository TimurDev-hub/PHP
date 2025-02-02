<?php

namespace Controllers\Routes;

use Controllers\Utils\HeaderController;
use Controllers\Services\RoutesService;

class DefaultController
{
	public function requireView(): void
	{
		$cards = RoutesService::renderCards() ?? [];

		$navbarLinks = HeaderController::requireNavbar();

		require_once(__DIR__ . '/../../views/templates/default.image.php');
	}
}
