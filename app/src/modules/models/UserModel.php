<?php

namespace Models;

use PDO;
use PDOException;
use Exception;

class UserModel
{
	const USERNAME_MIN_LENGTH = 4;
	const USERNAME_MAX_LENGTH = 16;
	const PASSWORD_MIN_LENGTH = 8;

	public function clearData(array $array): array
	{
		$clearedUserData = [];
	
		foreach ($array as $key => $value) {
			$clearedUserData[$key] = strval(htmlspecialchars(trim($value ?? '')));
		}
	
		return $clearedUserData;
	}

	public function validateData(array $clearedArray): array
	{
		$errors = [];

		foreach ($clearedArray as $key => $value) {
			switch ($key) {
				case 'username':
					if (empty($value)) {
						$errors[$key][] = 'Поле "Имя" обязательно';
					} elseif (strlen($value) < self::USERNAME_MIN_LENGTH || strlen($value) > self::USERNAME_MAX_LENGTH) {
						$errors[$key][] = 'Поле "Имя" должно быть от 4 до 16 символов';
					}
					break;
				case 'email':
					if (empty($value)) {
						$errors[$key][] = 'Поле "Email" обязательно';
					} elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
						$errors[$key][] = 'Поле "Email" имеет недопустимый формат';
					}
					break;
				case 'password':
					if (empty($value)) {
						$errors[$key][] = 'Поле "Пароль" обязательно';
					} elseif (strlen($value) < self::PASSWORD_MIN_LENGTH) {
						$errors[$key][] = 'Поле "Пароль" должно быть от 8 до 16 символов';
					}
					break;
			}
		}

		return $errors;
	}

	public function checkUserExists(PDO $pdo, string $username, string $email): bool
	{
		try {
			$stmt = $pdo->prepare("SELECT 1 FROM users WHERE user_name = ? OR user_email = ? LIMIT 1");
			$stmt->execute([$username, $email]);
			return $stmt->fetchColumn() > 0;

		} catch (PDOException) {
			throw new Exception();
		}
	}

	public function checkProfileExists(PDO $pdo, string $username, string $email): bool
	{
		try {
			$stmt = $pdo->prepare("SELECT 1 FROM users WHERE user_name = ? AND user_email = ? LIMIT 1");
			$stmt->execute([$username, $email]);
			return $stmt->fetchColumn() > 0;

		} catch (PDOException) {
			throw new Exception();
		}
	}

	public function registerUser(PDO $pdo, string $username, string $email, string $password): bool
	{
		try {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
			return $stmt->execute([$username, $email, $hashedPassword]);

		} catch (PDOException) {
			throw new Exception();
		}
	}

	public function getUserByData(PDO $pdo, string $username, string $email): array|false
	{
		try {
			$stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = ? AND user_email = ? LIMIT 1");
			$stmt->execute([$username, $email]);
			return $stmt->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException) {
			throw new Exception();
		}
	}

	public function updateUserData(PDO $pdo, int $userId, string $username, string $email): bool
	{
		try {
			$stmt = $pdo->prepare("UPDATE users SET user_name = ?, user_email = ? WHERE user_id = ?");
			return $stmt->execute([$username, $email, $userId]);

		} catch (PDOException) {
			throw new Exception();
		}
	}
}
