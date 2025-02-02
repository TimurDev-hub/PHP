<?php

namespace Controllers\Services;

use Models\CardModel;
use Core\Config\Database;
use PDOException;
use Exception;

class RoutesService
{
	public static function renderCards(): array|string|bool|null
	{
		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			return $card->loadRoutes(pdo: $pdo);

		} catch (Exception | PDOException) {
			return '<h3>Не удалось загрузить ассортимент.</h3>';
		}

	}
}