<?php

namespace Core\Config;

use Core\Config\env;
use Exception;
use PDO;
use PDOException;

class Database
{
	/*
	private static function loadEnv(): void
	{

	}
	*/

	public static function initPDO()
	{
		try {
			$pdo = new PDO(
				'pgsql:host=' . env::$dbHost .
				';dbname=' . env::$dbName .
				';user=' . env::$dbUser .
				';password=' . env::$dbPassword .
				';');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;

		} catch (Exception $exc) {
			throw new PDOException($exc->getMessage());
		}
	}
}
