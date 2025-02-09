<?php

namespace Controllers\Services;

use Models\{UserModel, CardModel};
use Helpers\AuthMessages;
use Core\Config\Database;
use Config\Errors\{UserAlreadyExists, ValidationError};
use PDOException;
use Exception;

class ProfileService
{
	public static function updateUserData(array $userData, mixed $userId): ?string
	{
		$renameStatus = [];

		try {
			$pdo = Database::initPDO();
			$user = new UserModel(userData: $userData);

			$clearedUserData = $user->clearData(array: $userData);
			$validatedErrors = $user->validateData(clearedArray: $clearedUserData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			if ($user->checkProfileExists(pdo: $pdo, username: $clearedUserData['username'], email: $clearedUserData['email'])) {
				throw new UserAlreadyExists();
			}

			$user->updateUserData(pdo: $pdo, userId: $userId, username: $clearedUserData['username'], email: $clearedUserData['email']);

			$_SESSION['user']['user_name'] = $clearedUserData['username'];
			$_SESSION['user']['user_email'] = $clearedUserData['email'];

			$renameStatus[] = 'Успешно!';

		} catch (ValidationError) {
			$renameStatus[] = $validatedErrors;

		} catch (UserAlreadyExists) {
			$renameStatus[] = 'Пользователь с таким именем или email уже существует.';

		} catch (Exception | PDOException) {
			$renameStatus[] = 'Что-то пошло не так!';
		}

		return AuthMessages::returnStatus(messages: $renameStatus);
	}

	public static function pushNewRoute(array $cardData): ?string
	{
		$cardStatus = [];

		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			$clearedCardData = $card->clearData(array: $cardData);
			$validatedErrors = $card->validateData(clearedArray: $clearedCardData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			$img = CardModel::saveUploadedFile();

			if ($img === false) {
				$cardStatus[] = 'Произошла ошибка!';
				return null;
			}

			if ($card->pushNewRoute(pdo: $pdo, img: $img, route: $clearedCardData['setRoute'], num: $clearedCardData['setNum'], time: $clearedCardData['setTime'], price: $clearedCardData['setPrice'])) {
				$cardStatus[] = 'Маршрут добавлен!';
			} else {
				$cardStatus[] = 'Произошла ошибка!';
			}

		} catch (ValidationError) {
			$cardStatus[] = $validatedErrors;

		} catch (Exception | PDOException) {
			$cardStatus[] = 'Что-то пошло не так!';
		}

		return AuthMessages::returnStatus(messages: $cardStatus);
	}

	public static function updateRoute(array $cardData): ?string
	{
		$routeStatus = [];

		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			$cardData = $card->clearData(array: $cardData);
			$validatedErrors = $card->validateData(clearedArray: $cardData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			if ($card->updateRoute(pdo: $pdo, id: $cardData['updateRoute'], route: $cardData['rName'], num: $cardData['rNum'], time: $cardData['rTime'], price: $cardData['rPrice'])) {
				$routeStatus[] = 'Данные обновлены!';
			} else {
				$routeStatus[] = 'Произошла ошибка!';
			}

		} catch (ValidationError) {
			$routeStatus[] = $validatedErrors;

		} catch (Exception | PDOException) {
			$routeStatus[] = 'Что-то пошло не так!';
		}

		return AuthMessages::returnStatus(messages: $routeStatus);
	}

	public static function findRouteById(array $cardData): array|string|null|bool
	{
		$routeStatus = [];

		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			$clearedCardData = $card->clearData(array: $cardData);
			$validatedErrors = $card->validateData(clearedArray: $clearedCardData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			return $card->findRouteById(pdo: $pdo, id: $clearedCardData['routeId']);

		} catch (ValidationError) {
			$routeStatus[] = $validatedErrors;

		} catch (Exception | PDOException) {
			$routeStatus[] = 'Что-то пошло не так!';
		}

		return AuthMessages::returnStatus(messages: $routeStatus);
	}

	public static function deleteRouteById(array $cardData): ?string
	{
		$routeStatus = [];

		try {
			$pdo = Database::initPDO();
			$card = new CardModel();

			$clearedCardData = $card->clearData(array: $cardData);
			$validatedErrors = $card->validateData(clearedArray: $clearedCardData);

			if (!empty($validatedErrors)) {
				throw new ValidationError();
			}

			$img = $card->selectImgById(pdo: $pdo, id: $clearedCardData['deleteRoute']);

			if ($card->deleteRouteById(pdo: $pdo, id: $clearedCardData['deleteRoute'])) {
				$card->deleteUploadedFile(path: $img[0]['c_img']);
				$routeStatus[] = 'Маршрут удалён!';
			} else {
				$routeStatus[] = 'Произошла ошибка!';
			}

		} catch (ValidationError) {
			$routeStatus[] = $validatedErrors;

		} catch (Exception | PDOException) {
			$routeStatus[] = 'Что-то пошло не так!';
		}

		return AuthMessages::returnStatus(messages: $routeStatus);
	}
}
