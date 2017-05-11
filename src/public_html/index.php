<?php
/**
 * +--------------------------+
 * | PROCORD.ORG FRONT PORTAL |
 * +--------------------------+
 */


ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


/**
* Auto load classes
*/
spl_autoload_register(function($class)
{
	// The parent directory
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file))
		require $file;
});



/**
 * Composer
 */
require '../vendor/autoload.php';



/**
 * Twig
 */
Twig_Autoloader::register();


/**
 * Config
 */
\app\Config::register();
