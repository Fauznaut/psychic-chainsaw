<?php
namespace core;

/**
 * Sessions
 */
class Sessions
{
	/**
	 * This will start a new session if it is needed
	 *
	 * @return void
	 */
	public static function start($force = false)
	{
		// Always start a session
		session_start();

		// Should we start a new session
		if ($force || !isset($_SESSION['new']) || $_SESSION['new'] === true)
		{
			// Empty the session
			$_SESSION = null;

			// Set default values
			$_SESSION['new'] = false;
			$_SESSION['loggedIn'] = false;
			$_SESSION['isAdmin'] = false;
		}
	}

	/**
	 * Check if the user is logged in
	 *
	 * @return boolean True if the user is, false otherwise
	 */
	public static function isUserLoggedIn()
	{
		return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
	}

	/**
	 * Check if the user is an admin
	 *
	 * @return boolean True if the user is, false otherwise
	 */
	public static function isUserAdmin()
	{
		if (self::isUserLoggedIn())
			return isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true;
		return false;
	}

	/**
	 * Get the user's ID
	 *
	 * @return integer or boolean Integer of the user's ID if logged in, false otherwise
	 */
	public static function getUserId()
	{
		return (self::isUserLoggedIn() && isset($_SESSION['user']['id']) && Validator::int($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : false;
	}
}
