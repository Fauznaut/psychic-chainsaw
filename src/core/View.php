<?php
namespace core;

use app\Config;
/**
 * View
 */
class View
{
	/**
	 * Render a view template using Twig
	 *
	 * @param string $template  The template file
	 * @param array $args Associative array of data to display in the view (optional)
	 *
	 * @return void
	 */
	public static function renderTemplate($template, $args = [])
	{
		static $twig = null;

		if ($twig === null)
		{
			$loader = new \Twig_Loader_Filesystem('../app/Views');

			if (Config::$PRODUCTION)
				$args['debug'] = false;
			else
				$args['debug'] = Config::$SHOW_ERRORS;

			$twig = new \Twig_Environment($loader, $args);
			unset($args['debug']);

			// Add Twig debugging
			if (!Config::$PRODUCTION && Config::$SHOW_ERRORS)
				$twig->addExtension(new \Twig_Extension_Debug());
		}

		// If the user is logged in or not
		$args['isUserLoggedIn'] = Sessions::isUserLoggedIn();

		// The HTTP_HOST
		$args['SP'] = Config::$SITE_FULL_PATH;

		echo $twig->render($template, $args);
	}
}
