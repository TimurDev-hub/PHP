<?php

namespace Controllers\Utils;

class HeaderController
{
	private const ACCOUNT = 'account';
	private const DEFAULT = 'default';
	private const PROFILE = 'profile';

	private static function returnStaticAttributes(): array
	{
		return [
			self::DEFAULT => ['href' => '/default', 'target' => '_self']
		];
	}

	private static function returnStaticContent(): array
	{
		return [
			self::DEFAULT => 'Главная'
		];
	}

	private static function returnDinamicLinks(): array
	{
		$navbarAttributes = [];
		$navbarContent = [];

		if (isset($_SESSION['admin'])) {
			$navbarAttributes[self::PROFILE] = ['href' => '/profile', 'target' => '_self'];
			$navbarContent[self::PROFILE] = 'Админ';

		} elseif (isset($_SESSION['user'])) {
			$navbarAttributes[self::PROFILE] = ['href' => '/profile', 'target' => '_self'];
			$navbarContent[self::PROFILE] = 'Профиль';

		} else {
			$navbarAttributes[self::ACCOUNT] = ['href' => '/account', 'target' => '_self'];
			$navbarContent[self::ACCOUNT] = 'Аккаунт';
		}

		return [
			'navbarAttributes' => $navbarAttributes,
			'navbarContent' => $navbarContent
		];
	}

	private static function renderHtmlLinks(array $attributes, string $content): string
	{
		$navbarLink = '';

		foreach ($attributes as $attribute => $value) {
			$navbarLink .= " $attribute=\"$value\"";
		}

		return "<a{$navbarLink}>{$content}</a>";
	}

	public static function requireNavbar(): array
	{
		$navbarAttributes = self::returnStaticAttributes();
		$navbarContent = self::returnStaticContent();
		$navbarDinamicLinks = self::returnDinamicLinks();

		$navbarAttributes = array_merge($navbarAttributes, $navbarDinamicLinks['navbarAttributes']);
		$navbarContent = array_merge($navbarContent, $navbarDinamicLinks['navbarContent']);

		$navbarLinks = [];

		foreach ($navbarAttributes as $route => $attributes) {
			$navbarLinks[$route] = self::renderHtmlLinks(attributes: $attributes, content: $navbarContent[$route]);
		}

		return $navbarLinks;
	}
}
