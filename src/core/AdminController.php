<?php
namespace core;

/**
 * Admin controller
 */
abstract class AdminController extends BaseController
{
	/**
	 * Where to send the user if they are not an admin
	 *
	 * @var string
	 */
	protected $redirectNotAdmin = '';

	/**
	 * Before filter - called before an action method.
	 *
	 * @return void
	 */
	protected function before()
	{
		if (!Sessions::isUserAdmin())
		{
			Utilities::redirect($this->redirectNotAdmin);
			return false;
		}
	}
}
