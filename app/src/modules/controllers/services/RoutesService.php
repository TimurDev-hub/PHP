<?php

namespace Controllers\Services;

use Models\CardModel;
use Core\Config\Database;
use PDOException;
use Exception;

class RoutesService
{
	public static function renderCards(): array|string
	{
		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			$cards = $card->loadRoutes(pdo: $pdo);

			if (empty($cards)) {
				return '<div class="route-load-error"><h3>Не удалось загрузить ассортимент.</h3></div>';
			}

			return $cards;

		} catch (Exception | PDOException) {
			return '<div class="route-load-error"><h3>Не удалось загрузить ассортимент.</h3></div>';
		}
	}
}