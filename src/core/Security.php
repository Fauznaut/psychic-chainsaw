<?php
namespace core;

use \IcyApril\CryptoLib;
use app\Config;
/**
 * Security
 */
class Security
{
	/**
	 * This will set the instance of CryptoLib's pepper
	 *
	 * @return void
	 */
	public static function load()
	{
		CryptoLib::changePepper(Config::$CRYPTOLIB_PEPPER);
	}

	/**
	 * Hashes a string using CryptoLib's pepper
	 *
	 * @param string $string Hash this
	 *
	 * @return string
	 */
	public static function hash($string)
	{
		return CryptoLib::hash($string);
	}

	/**
	 * Validates a hash and some string
	 *
	 * @param string $hash Hashed data to be validated
	 * @param string $against Something to compare against
	 *
	 * @return boolean
	 */
	public static function validate($hash, $against)
	{
		return CryptoLib::validateHash($hash, $against);
	}
}
