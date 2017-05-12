<?php
namespace core;

use \PDO;
use app\Config;

/**
 * Base model
 */
abstract class Model
{
	/**
	 * Get the PDO database connection
	 *
	 * @return mixed
	 */
	protected static function getDB()
	{
		static $db = null;

		if ($db === null) {
			$dbcs = 'mysql:host='
					. Config::$DATABASE_DATA['host']
					. ';port=' . Config::$DATABASE_DATA['port']
					. ';dbname=' . Config::$DATABASE_DATA['base']
					. ';charset=utf8';

			$db = new PDO($dbcs, Config::$DATABASE_DATA['user'], Config::$DATABASE_DATA['pass']);

			// Throw an Exception when an error occurs
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		return $db;
	}
}
