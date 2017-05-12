<?php
namespace core;

use \DateTime;
use \DateTimeZone;
use \IcyApril\CryptoLib;
/**
 * Utilities class
 */
class Utilities
{
	/**
	 * Get a user's IP address
	 *
	 * @return string
	 */
	public static function getIp()
	{
		if (getenv('HTTP_CLIENT_IP'))
			$ip = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ip = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ip = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ip = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ip = getenv('REMOTEs_ADDR');
		else
			$ip = 'N/A';

		return $ip;
	}

	/**
	 * Get the current time's timestamp
	 *
	 * @return datetime
	 */
	public static function getNow($condensed = false)
	{
		$timezone = new DateTimeZone('America/New_York');
		$now = new DateTime();
		$now->setTimezone($timezone);
		if ($condensed)
			return $now->format('Ymdhis');
		else
			return $now->format('Y\-m\-d\ h:i:s');
	}

	/**
	 * Generates a random string based on given length
	 *
	 * @param integer $length The amount of characters in the string
	 *
	 * @return string
	 */
	public static function genString($length = 64)
	{
		return CryptoLib::randomString($length);
	}

	/**
	 * Redirects the user to another location using a header.
	 *
	 * @param string $path The relative path where the user will be sent to
	 *
	 * @return void
	 */
	public static function redirect($path = '')
	{
		header('Location: ' . Config::$SITE_FULL_PATH . $path, true, 303);
		exit();
	}

	/**
	 * If the user is logged in, redirect them to their profile
	 *
	 * @return void
	 */
	public static function ifUserIsLoggedInRedirectToProfile()
	{
		if (Sessions::isUserLoggedIn())
			Utilities::redirect('user/' . Sessions::getUserId());
	}
}
