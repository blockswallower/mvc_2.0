<?php

class Controller {
	/*
	 * This class is a
	 * blueprint for all the other
	 * controllers
	 */

	/*
	 * @var array
	 */
	protected $globals;

	/*
	 * @var object
	 */
	protected $view;

	/*
	 * @var string
	 */
	protected $model;

	/*
	 * @var array
	 */
	protected $config;

	/*
	 * @var string
	 */
	protected $modelsdir = 'models/';

	/*
	 * @var string
	 */
	protected $libsdir = 'lib/';

	public function __construct() {
		/*
		 * This is needed for 
		 * being able to redirect 
		 * after a function call
		 */
		ob_start();

		/*
		 * Starts the session
		 * on every page
		 */
		Sessions::init();
		
		/*
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

	/*
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
		/*
		 * @var String
		 */
		$model = ucfirst($model)."Model";

		/*
		 * @var String
		 */
		$path = $this->modelsdir . $model.".php";

		if (file_exists($path)) {
			require $path;

			/*
			 * @var Object
			 */
			$this->$model = new $model();
		} else {
			Debug::exitdump($model . ".php doesn't exist");
		}
	}

	/*
	 * @param $library
	 *
	 * loads in library based on the parameter
     */
	public function load_library($library) {
		/*
		 * @var String
		 */
		$path = $this->libsdir . $library . '/' . $library . '.php';

		if (file_exists($path)) {
			require $path;
		} else {
			Debug::exitdump($library . ".php doesn't exist");
		}
	}

	/*
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

	/*
	 * This allows templates to access
	 * global variables
	 */
	public function config_template_globals() {
		$this->view->globals = $this->globals;
	}

	/*
	 * Returns the controller the user
	 * is currently using
	 */
	public static function return_current_controller() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			/*
			 * Will set the current controller
			 * to Config::get("STANDARD_CONTROLLER")
			 * if no controller was found
			 */
			$url[0] = Config::get("STANDARD_CONTROLLER");
		}

		return $url[0];
	}
}