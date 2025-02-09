<?php

namespace Helpers;

use Throwable;

class ErrorsLogger
{
	private static function getHeader(): string
	{
		return 'PHP FATAL ERROR: ' . date('Y-m-d H:i:s') . ': ';
	}

	private static function getInfo(Throwable $exc): string
	{
		return 'gM =|> ' . htmlspecialchars($exc->getMessage()) . ' gF =|> ' . $exc->getFile() . ' gL =|> ' . $exc->getLine();
	}

	private static function getLogFilePath(): string
	{
		return __DIR__ . '/../../core/logs/standartErrors.log';
	}

	public static function handleError(Throwable $exc): void
	{
		$errorHeader = ErrorsLogger::getHeader();
		$errorInfo = ErrorsLogger::getInfo(exc: $exc);

		if (strpos($errorInfo, 'static') !== false) return;
		if (strpos($errorInfo, '/favicon.ico') !== false) return;

		$logFile = ErrorsLogger::getLogFilePath();

		$errorMessage = $errorHeader . $errorInfo . PHP_EOL;

		$_SESSION['routesError'] = 'FATAL ERROR: ' . htmlspecialchars($exc->getMessage());

		error_log($errorMessage, 3, $logFile);
		header('location: /error');
		exit;
	}
}
