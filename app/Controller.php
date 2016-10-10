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
	protected $globals;

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

	/**
	 * @var string
	 */
	protected $modelsdir = 'models/';

	public function __construct() {
		/**
		 * This is needed for 
		 * being able to redirect 
		 * after a function call
		 */
		ob_start();

		/**
		 * Starts the session
		 * on every new page
		 */
		Sessions::init();
		
		/**
		 * Create a new View object.
		 * This will be created for 
		 * every child controller
		 */
		$this->view = new View();

		/**
		 * Create a new Settings object
		 *
		 * Access with: Settings::$config[ARRAY_INDEX]
		 */
		$this->settings = new Settings();
	}

	/**
	 * @param $model
	 *
	 * Loads the model in the given
	 * parameter
	 *
	 * Controller:
	 *
	 * $this->loadmodel('index');
	 *
	 * $this->index->[FUCTION_CALL]
     */
	public function loadmodel($model) {
		$ucfirstModel = ucfirst($model)."Model";

		$path = $this->modelsdir.$ucfirstModel.".php";

		if (file_exists($path)) {
			require $path;

			$this->$model = new $ucfirstModel();
		} else {
			Debug::exitdump($ucfirstModel." Doesn't exist");
		}
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
	 *
	 * or:
	 *
	 * $this->get([KEY])
     */
	public function set($controller, $key, $value) {
		$this->globals[$controller][$key] = $value;
	}

	/**
	 * This allows templates to access
	 * global variables
	 */
	public function config_template_globals() {
		$this->view->globals = $this->globals;
	}

	/**
	 * Returns the controller the user
	 * is currently in
	 */
	public static function return_current_controller() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			/*
			 * Will set the current controller
			 * to Settings::$config["STANDARD_CONTROLLER"]
			 * if no controller was found
			 */
			$url[0] = Settings::$config["STANDARD_CONTROLLER"];
		}

		return $url[0];
	}
}