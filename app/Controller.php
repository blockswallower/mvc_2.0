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
}