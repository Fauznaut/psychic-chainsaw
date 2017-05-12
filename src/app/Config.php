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
	 * Email settings
	 *
	 * @var array
	 */
	public static $MAILER_DATA;

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
	public static $CRYPTOLIB_PEPPER = 'QAvUVh9pmAqMSExRkzLwZOw8T5zt7AeCOjJvxPH9R5ZqCTBH4xsLWDO4MWBx0ea74GRjDSk4bHFYdrxe07ytqLuBf5JBQqB9YvtJ0aEinnz2iZaafQ1aAwKAww01JUen3DkFhDSHirqT8DlQSO5MyTrVWQxJeJzjONSc8RHlw30InqmjXTEHa7rMfqVpUoWpVFFBhtt2uDdtDFfloBU7ysCKvpXUm9DYhAwk42BEZ34WoovNZYqPS3rLoPUmnfwbgTsTvAjsYSVqI1pCHxLALzHXuYYdaB5BpXHQFwBqYS21LZ1LPdhw9ZvOhWkiooOkdOkOlxvQEYvD2nA4RDGBHqpmfIHKBqPPlixyNZq1qXOUK5o1SS1QS6PaJrkXMfbzqLEd6PPVHFGtMTzNc4JYKa6X7SiwajQteqhTceKqSiX0YMmBoMqyLW8XWETgb6kfUi5qMx7XEMBC0tcjlkOxQbNM1eZqqsb9wZBcZTzsvFpxhG0jlzP2K7Lz9xtoQOTfyGypZmSox2wWKlhGpQZFnS1sWzREy7IbO8aqImAKlljsEG4LtRnfUMPDEWC8kvxjpUgL4tCvIeHT209jdClifDW8SENiVnPCPoXtROsxhoc7GxDn';
}
