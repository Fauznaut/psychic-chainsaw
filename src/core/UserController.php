<?php
namespace core;

/**
 * User controller
 */
abstract class UserController extends BaseController
{
	/**
	 * Where to send the user if they are not logged in
	 *
	 * @var string
	 */
	protected $redirectNotLoggedIn = '';

	/**
	 * Before filter - called before an action method.
	 *
	 * @return void
	 */
	protected function before()
	{
		if (!Sessions::isUserLoggedIn())
		{
			Utilities::redirect($this->redirectNotLoggedIn);
			return false;
		}
	}
}
