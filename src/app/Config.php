<?php
namespace app;

/**
 * Config (contains non-production logins)
 */
class Config
{
	/**
	 * Is the site production or not
	 *
	 * @var boolean
	 */
	public static $PRODUCTION = false;

	/**
	 * Should we show errors
	 *
	 * @var boolean
	 */
	public static $SHOW_ERRORS = true;

	/**
	 * The site's path
	 *
	 * @var string
	 */
	public static $SITE_PATH = 'psychic-chainsaw/src/public_html/';

	/**
	 * The site's path and host
	 *
	 * @var string
	 */
	public static $SITE_FULL_PATH;

	/**
	 * The production config file path
	 *
	 * @var string
	 */
	protected static $PRODUCTION_CONFIG_PATH = '../app/ConfigProd.php';

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

	/**
	 * This will determing if the config/site is production
	 *
	 * @return void
	 */
	public static function register()
	{
		// Setup the SITE_FULL_PATH
		Config::$SITE_FULL_PATH = isset($_SERVER["HTTPS"]) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . '/' . Config::$SITE_PATH;

		// If the production config is present
		if (file_exists(Config::$PRODUCTION_CONFIG_PATH) && is_readable(Config::$PRODUCTION_CONFIG_PATH))
		{
			// Try to initialize the production config
			$ConfigProd = new ConfigProd;

			// If the register function exists in the production config
			if (method_exists($ConfigProd, 'register'))
				ConfigProd::register();
		}
	}

	/**
	 * Add the routes to the router
	 *
	 * @param object &$router The router object
	 *
	 * @return void
	 */
	public static function addRoutes(&$router)
	{
		// Static routes (home/index)
		$router->add('', ['controller' => 'Home', 'action' => 'index']);

		// Dynamic routes (general)
		$router->add('{controller}', ['action' => 'index']);
		$router->add('{controller}/{action}');
		$router->add('{controller}/{id:\d+}', ['action' => 'view']);
		$router->add('{controller}/{id:\d+}/{action}');
	}

	/**
	 * The IcyApril/CryptoLib pepper
	 *
	 * @var string
	 */
	public static $CRYPTOLIB_PEPPER = 'u9k3HvsC8Slm0Qj5kr0GeZP3LOWgIT4ivJIqHhhwJB4J7D0udfde4EC21kmiyeuoG6lWmwKxo7XSApSnYnmqKM0zhUwsxQWaYWp0PgRTghOdIVmgq1ibLdKiZYktVkBmmm4lB9V0z7w91Ya6QPhQAKXOctCDW5awXwUJElS5SlSqHnVwTCZDSHkBjvnQArnysPmlWPvdQO2pWRSxb0gj0HumFQexlOl52Gof7Gp11cjXOz1lB3BEuOAkMaM6to1ZmIs7logZHaVzjUlrhfDzWEReqSr8dVyyOt0m67pyoZrEDgtJge0Dfh4Uou4Kv7PHqvY8qKJgmOiJE4FKyCu3WgUtwMzw5Wf2S0VDMZg1t5OHMvmj2VIpI2pzlix6pufnNgcPG1Xe2kftdlAwtwcVxKz4d1IHKxBVSLEa6cjR4BC0O2NeT3FBehkXbOkbwQnqDWhsIXrRQtQgNufAfTt6hec7vsTLPVZ24S5k3RoCwpzG5NZZgzbNyizUynrNjyozX11Ey4xmXirCWbbPZeeSAM8KnJKmW53tQ2LF2fMsaBeLvPk1SzA0Ne2UYEz3LtaMitMqSMbvhDWDwlhbHz4an79rALRveseFeCH8RCadyJzwsHuj';
}
