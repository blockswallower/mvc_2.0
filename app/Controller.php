<?php

class Controller {
	/**
	 * This class is the standard
	 * blueprint for all the other
	 * controllers
	 */
	
	/**
	 * @var array
	 */
	protected $variables;

	/**
	 * @var object
	 */
	protected $view;

	/**
	 * @var string
	 */
	protected $model;

	/**
	 * @var array
	 */
	protected $settings;
	
	
	public function __construct() {
		/**
		 * Create a new View object.
		 * This will be created for 
		 * every child controller
		 */
		$this->view = new View();

		/**
		 * Create a new Settings object
		 */
		$this->settings = new Settings();
	}

	public function load_model() {

	}

	/**
	 * @param $controller
	 * @param $key
	 * @param $value
	 *
	 * This method will 'send' a variable
	 * to the current view
	 *
	 * Controller:
	 *
	 * $test = [VALUE];
	 * $this->set([CONTROLLER_NAME], [KEY], [VALUE])
	 *
	 * View:
	 *
	 * $this->var[CONTROLLER_NAME][KEY]
     */
	public function set($controller, $key, $value) {
		$this->variables[$controller][$key] = $value;
	}

	/**
	 * This allows us to access the
	 * variables we send to the view
	 * with the set() method
	 */
	public function config_view_array() {
		$this->view->var = $this->variables;
	}
}