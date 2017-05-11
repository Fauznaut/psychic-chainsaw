<?php
namespace core;

use \app\Config;

/**
 * Error and exception handler
 */
class Errors
{
	/**
	 * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
	 *
	 * @param int $level  Error level
	 * @param string $message  Error message
	 * @param string $file  Filename the error was raised in
	 * @param int $line  Line number in the file
	 *
	 * @return void
	 */
	public static function errorHandler($level, $message, $file, $line)
	{
		// to keep the @ operator working
		if (error_reporting() !== 0)
			throw new \ErrorException($message, 0, $level, $file, $line);
	}

	/**
	 * Exception handler.
	 *
	 * @param Exception $exception  The exception
	 *
	 * @return void
	 */
	public static function exceptionHandler($exception)
	{
		// Code is 404 (not found) or 500 (general error)
		$code = $exception->getCode();
		if ($code != 404)
			$code = 500;

		http_response_code($code);

		if (!Config::$PRODUCTION && Config::$SHOW_ERRORS || Sessions::isUserAdmin())
		{
			if (Config::$PRODUCTION || !Config::$SHOW_ERRORS && Sessions::isUserAdmin())
			{
				View::renderTemplate("Errors/admin.twig", [
					'title' => $code,
					'error' => [
						'uncaughtException' => get_class($exception),
						'message' => $exception->getMessage(),
						'stackTrace' => $exception->getTraceAsString(),
						'thrownIn' => $exception->getFile()
					]
				]);
				return;
			}
			else
			{
				View::renderTemplate("Errors/non-admin-with-reporting.twig", [
					'title' => $code,
					'error' => [
						'uncaughtException' => get_class($exception),
						'message' => $exception->getMessage(),
						'stackTrace' => $exception->getTraceAsString(),
						'thrownIn' => $exception->getFile()
					]
				]);
				return;
			}
		}
		else
		{
			$log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
			ini_set('error_log', $log);

			$message = "Uncaught exception: '" . get_class($exception) . "'";
			$message .= " with message '" . $exception->getMessage() . "'";
			$message .= "\nStack trace: " . $exception->getTraceAsString();
			$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

			error_log($message);

			if (Sessions::isUserAdmin())
			{
				View::renderTemplate("Errors/admin.twig", [
					'title' => $code,
					'error' => [
						'uncaughtException' => get_class($exception),
						'message' => $exception->getMessage(),
						'stackTrace' => $exception->getTraceAsString(),
						'thrownIn' => $exception->getFile()
					]
				]);
				return;
			}
			else
				View::renderTemplate("Errors/non-admin-without-reporting.twig", ['title' => $code]);
		}
	}
}
