<?php
namespace app\Controllers;

/**
 * Home controller
 */
class HomeController extends \core\BaseController
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		// This will set the title of the page
		$this->template_vars['title'] = 'Home';

		// This will render the page provided
		$this->render('Home/index.twig');
	}
}
