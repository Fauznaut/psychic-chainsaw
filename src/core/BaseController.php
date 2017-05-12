<?php
namespace core;

/**
 * Base controller
 */
abstract class BaseController
{
	/**
	 * Variables for the template
	 *
	 * @var array
	 */
	protected $template_vars = [];

	/**
	 * Parameters from the matched route
	 *
	 * @var array
	 */
	protected $route_params = [];

	/**
	 * Class constructor
	 *
	 * @param array $route_params  Parameters from the route
	 *
	 * @return void
	 */
	public function __construct($route_params)
	{
		$flg = [];
		foreach ($route_params as $key => $value)
		{
			if (!(strtolower($key) === 'action' || strtolower($key) === 'controller'))
				$flg[$key] = $value;
		}
		$this->route_params = $flg;
	}

	/**
	 * Magic method called when a non-existent or inaccessible method is
	 * called on an object of this class. Used to execute before and after
	 * filter methods on action methods. Action methods need to be named
	 * with an "Action" suffix, e.g. indexAction, showAction etc.
	 *
	 * @param string $name  Method name
	 * @param array $args Arguments passed to the method
	 *
	 * @return void
	 */
	public function __call($name, $args)
	{
		$method = $name . 'Action';

		if (method_exists($this, $method))
		{
			$this->always();
			if ($this->before() !== false)
			{
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		}
		else
			throw new \Exception("Method $method not found in controller " . get_class($this), 404);
	}

	/**
	 * Always run
	 *
	 * @return void
	 */
	protected function always(){}

	/**
	 * Before filter - called before an action method.
	 *
	 * @return void
	 */
	protected function before(){}

	/**
	 * After filter - called after an action method.
	 *
	 * @return void
	 */
	protected function after(){}

	/**
	 * View render wrapper
	 *
	 * @param string $template  The template file
	 * @param array $args  Associative array of data to display in the view (optional)
	 *
	 * @return void
	 */
	protected function renderAction($template, $args = [])
	{
		// So we can assign vars from other actions in the controller
		$args = array_merge($args, $this->template_vars);

		View::renderTemplate($template, $args);
	}
}
