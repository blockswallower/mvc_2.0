<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Controller {
	/**
	 * Globals array
	 */
	protected $globals;

	/**
	 * View object
	 */
	protected $view;

	/**
	 * Model object
	 */
	protected $model;

	/**
	 * Config object
	 */
	protected $config;

	/**
	 * models directory
	 */
	protected $modelsdir = 'models/';

	/**
	 * libs directory
	 */
	protected $libsdir = 'lib/';

	public function __construct() {
		/**
		 * This is needed for 
		 * being able to redirect 
		 * after a function call
		 */
		ob_start();

		/**
		 * Starts the session
		 * on every page
		 */
		Sessions::init();
		
		/**
		 * Create a new View object on every page
		 */
		$this->view = new View();

		/**
		 * Create a new Config object
		 *
		 * Access with:
		 *
		 * Config::$config[KEY]
		 *
		 * or:
		 *
		 * Config::get(KEY)
		 *
		 */
		$this->config = new Config();
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
	public function load_model($model) {
		$model = ucfirst($model)."Model";
		$path = $this->modelsdir . $model.".php";

		if (file_exists($path)) {
			require_once $path;

			$this->$model = new $model();
		} else {
			Debug::exitdump($model . ".php doesn't exist", __LINE__, "app/Controller");
		}
	}

	/**
	 * @param $library
	 *
	 * loads in library based on the parameter
     */
	public function load_library($library) {
		$path = $this->libsdir . $library . '/' . $library . '.php';

		if (file_exists($path)) {
			require $path;
		} else {
			Debug::exitdump($library . ".php doesn't exist", __LINE__, "app/Controller");
		}
	}

	/**
	 * @param $controller
	 * @param $key
	 * @param $value
	 *
	 * This method will 'send' a variable
	 * to your view
	 *
	 * Controller:
	 *
	 * $test = [VALUE];
	 * $this->set([CONTROLLER_NAME], [KEY], $test);
	 *
	 * View:
	 *
	 * $this->var[CONTROLLER_NAME][KEY];
	 *
	 * or:
	 *
	 * $this->get([KEY]);
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
	 * is currently using
	 */
	public static function return_current_controller() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			/**
			 * Will set the current controller
			 * to Config::get("STANDARD_CONTROLLER")
			 * if no controller was found
			 */
			$url[0] = Config::get("STANDARD_CONTROLLER");
		}

		return $url[0];
	}
}