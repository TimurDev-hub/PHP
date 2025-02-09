<?php

namespace Models;

use PDO;
use PDOException;
use Exception;

class CardModel
{
	private const MIN_LENGTH = 2;
	private const MAX_LENGTH = 60;

	public function clearData(array $array): array
	{
		$clearedCardData = [];
	
		foreach ($array as $key => $value) {
			$clearedCardData[$key] = strval(htmlspecialchars(trim($value ?? '')));
		}
	
		return $clearedCardData;
	}

	public function validateData(array $clearedArray): array
	{
		$errors = [];

		foreach ($clearedArray as $key => $value) {

			if (empty($value)) {
				$errors['empty'] = 'Все поля обязательны для заполнения';
			} elseif (mb_strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
				$errors['non-correct-length'] = 'Значения должны быть от 1 до 30 символов';
			}
		}

		return $errors;
	}

	public function pushNewRoute(PDO $pdo, string $img, string $route, string $num, string $time, string $price): bool
	{
		try {
			$stmt = $pdo->prepare("INSERT INTO cards (c_img, c_route, c_num, c_time, c_price) VALUES (?, ?, ?, ?, ?)");
			return $stmt->execute([$img, $route, $num, $time, $price]);

		} catch (Exception) {
			throw new PDOException();
		}
	}

	public function updateRoute(PDO $pdo, string $id, string $route, string $num, string $time, string $price): bool
	{
		try {
			$stmt = $pdo->prepare("UPDATE cards SET c_route = ?, c_num = ?, c_time = ?, c_price = ? WHERE id = ?");
			return $stmt->execute([$route, $num, $time, $price, $id]);

		} catch (Exception) {
			throw new PDOException();
		}
	}

	public function loadRoutes(PDO $pdo): array|bool|null
	{
		try {
			$stmt = $pdo->prepare("SELECT * FROM cards");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception) {
			throw new PDOException();
		}
	}

	public function findRouteById(PDO $pdo, string $id): array|bool|null
	{
		try {
			$stmt = $pdo->prepare("SELECT * FROM cards WHERE id = ? LIMIT 1");
			$stmt->execute([$id]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception) {
			throw new PDOException();
		}
	}

	public function deleteRouteById(PDO $pdo, string $id): bool
	{
		try {
			$stmt = $pdo->prepare("DELETE FROM cards WHERE id = ?");
			return $stmt->execute([$id]);
		} catch (Exception) {
			throw new PDOException();
		}
	}

	public function selectImgById(PDO $pdo, string $id): array|null|bool
	{
		try {
			$stmt = $pdo->prepare("SELECT c_img FROM cards WHERE id = ?");
			$stmt->execute([$id]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception) {
			throw new PDOException();
		}
	}

	public static function saveUploadedFile(): string|false
	{
		$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
		$file = $_FILES['setImg'];
		$uploadDir = __DIR__ . '/../../../static/img/uploads/';

		if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
			return false;
		}

		if (!in_array($file['type'], $allowedTypes)) {
			return false;
		}

		$filename = uniqid() . '-' . $file['name'];

		if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
			return "/app/static/img/uploads/{$filename}";
		} else {
			return false;
		}
	}

	public static function deleteUploadedFile(string $path): void
	{
		$allowedTypes = ['.jpeg', '.png', '.jpg'];
		
		$file = str_replace('/app/static/img/uploads/', __DIR__ . '/../../../static/img/uploads/', $path);

		foreach ($allowedTypes as $type) {
			if (strpos($file, $type) !== false) unlink($file);
		}
	}
}
