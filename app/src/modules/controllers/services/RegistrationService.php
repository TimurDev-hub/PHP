<?php

namespace Controllers\Services;

use Models\UserModel;
use Core\Config\Database;
use Config\Errors\{ValidationError, UserAlreadyExists};
use Exception;
use PDOException;
use Helpers\AuthMessages;

class RegistrationService
{
	public static function processRegistration(array $userData): ?string
	{
		$regStatus = [];

		try {
			$pdo = Database::initPDO();
			$user = new UserModel();

			$clearedUserData = $user->clearData(array: $userData);
			$validatedErrors = $user->validateData(clearedArray: $clearedUserData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			if ($user->checkUserExists(pdo: $pdo, username: $clearedUserData['username'], email: $clearedUserData['email'])) {
				throw new UserAlreadyExists();
			}

			if ($user->registerUser(pdo: $pdo, username: $clearedUserData['username'], email: $clearedUserData['email'], password: $clearedUserData['password'])) {
				$regStatus[] = 'Регистрация прошла успешно!';
			} else {
				$regStatus[] = 'Ошибка при сохранении данных!';
			}

		} catch (ValidationError) {
			$regStatus[] = $validatedErrors;

		} catch (UserAlreadyExists) {
			$regStatus[] = 'Пользователь с таким именем или email уже существует.';

		} catch (Exception | PDOException) {
			$regStatus[] = 'Произошла ошибка!';
		}

		return AuthMessages::returnStatus(data: $regStatus);
	}
}
