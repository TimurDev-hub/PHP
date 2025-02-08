<?php

namespace Controllers\Services;

use Models\UserModel;
use Core\Config\Database;
use Config\Errors\{ValidationError, UncorrectData};
use PDOException;
use Exception;
use Helpers\AuthMessages;

class LoginService
{
	public static function processLogin(array $userData): ?string
	{
		$logStatus = [];

		try {
			$pdo = Database::initPDO();
			$user = new UserModel();

			$clearedUserData = $user->clearData(array: $userData);
			$validatedErrors = $user->validateData(clearedArray: $clearedUserData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			$dbUser = $user->getUserByData(pdo: $pdo, username: $clearedUserData['username'], email: $clearedUserData['email']);

			if (!$dbUser || !password_verify($clearedUserData['password'], $dbUser['user_password'])) {
				throw new UncorrectData();
			}

			if ($clearedUserData['username'] === 'admin' && $clearedUserData['email'] === 'admin@gmail.com') {
				$_SESSION['admin'] = $dbUser;
			} else {
				$_SESSION['user'] = $dbUser;
			}

			header('Location: /profile');
			exit;

		} catch (ValidationError) {
			$logStatus[] = $validatedErrors;

		} catch (UncorrectData) {
			$logStatus[] = 'Неверный username, email или пароль.';

		} catch (Exception | PDOException) {
			$logStatus[] = 'Произошла ошибка!';
		}

		return AuthMessages::returnStatus(messages: $logStatus);
	}
}
