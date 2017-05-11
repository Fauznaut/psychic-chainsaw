<?php
namespace app;

/**
 * Config (contains non-production logins)
 */
class Config
{
	/**
	 * Database connection data
	 *
	 * @var array
	 */
	public static $DATABASE_DATA = [
		'host' => '127.0.0.1',
		'port' => '8889',
		'user' => 'PC_User',
		'pass' => 'dzSRRzpq37%@EGf^Bcp6',
		'base' => 'PC_Master'
	];

	public static function init()
	{
		var_dump(Config::$DATABASE_DATA);
		if (file_exists('../app/ConfigProd.php'))
		{
			ConfigProd::initProd();
			var_dump(Config::$DATABASE_DATA);
		}
	}
}
