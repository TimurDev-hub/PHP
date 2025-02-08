<?php

namespace Helpers;

class AuthMessages
{
	/*
	private static function displayMessage(array|string $dbMessage): ?string
	{
		if (empty($dbMessage)) {
			return null;
		}

		if (is_array($dbMessage)) {
			$stringMessage = '';

			foreach ($dbMessage as $messages) {
				if (is_array($messages)) {
					foreach ($messages as $message) {
						$stringMessage .= "<p class=\"messages__standart\">STATUS: " . $message . '</p>';
					}
				} else {
					$stringMessage .= "<p class=\"messages__standart\">STATUS: " . $messages . '</p>';
				}
			}

			return "<div class=\"global__process-messages\">{$stringMessage}</div>";
		}

		return "<div class=\"global__process-messages\"><p class=\"messages__standart\">STATUS: " . $dbMessage . '</p></div>';
	}
	*/

	public static function returnStatus(array $messages): ?string
	{
		if (!empty($messages)) {
			return "<div class=\"global__process-messages\">" . self::displayMessageRecursive(dbMessage: $messages) . "</div>";
		}

		return null;
	}

	public static function displayMessageRecursive(array $dbMessage): ?string
	{
		if (empty($dbMessage)) {
			return null;
		}

		$stringMessage = '';

		foreach ($dbMessage as $message) {
			if (is_array($message)) {
				$stringMessage .= self::displayMessageRecursive($message);
			} else {
				$stringMessage .= '<p class="messages__standart">STATUS: ' . $message . '</p>';
			}
		}

		return $stringMessage;
	}
}
