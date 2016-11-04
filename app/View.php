<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class View {
	/**
	 * This class is the a
	 * blueprint for all the other
	 * views
	 */

	/**
	 * @var array
	 */
	public $globals;

	/**
	 * @var String
	 */
	protected $basepath = 'views/';

	/**
	 * @var String
	 */
	protected $header = 'views/layout/header.php';

	/**
	 * @var String
	 */
	protected $footer = 'views/layout/footer.php';

	/**
	 * @var Boolean
	 */
	protected $rendered;

	/**
	 * @param null $key
	 * @return mixed
	 *
	 * returns a value from the "gloabals" variable
	 * can be used in views like this:
	 *
	 * $this->get([KEY]);
	 */
	public function get($key = null) {
		/**
		 * @var String
		 */
		$cur_controller = Controller::return_current_controller();

		if (!empty($this->globals[$cur_controller])) {
			if (!empty($key)) {
				$value = $this->globals[$cur_controller][$key];

				if (!empty($value)) {
					return $value;
				} else {
					Debug::exitdump('The value you are trying to access is empty or NULL', __LINE__, "app/View");
				}
			} else {
				Debug::exitdump('Please enter an array key as an argument: $this->get([KEY])', __LINE__, "app/View");
			}
		} else {
			Debug::exitdump("No variables have been send from this controller yet: " . ucfirst($cur_controller) . "Controller", __LINE__, "app/View");
		}

		return $key;
	}

	/**
	 * @param $view
	 * @param $globals
	 *
	 * This method renders
	 * the requested view
	 * from the controller
	 * with header and footer
	 * included
	 */
	public function show_hf($view, $globals = null) {
		if (file_exists($this->get_view_path($view))) {
			if (file_exists($this->header)) {
				if (file_exists($this->footer)) {
					/**
					 * Configure global variables
					 */
					if (!empty($globals)) {
						$this->globals = $globals;
					}

					$this->require_header();
					$this->render_view($view);
					$this->require_footer();

					/**
					 * Requires post request handler
					 * for capturing post requests
					 */
					$this->require_post_request_handler();

					/**
					 * Confirms that everything
					 * has rendered properly
					 */
					$this->rendered = true;
				} else {
					Debug::exitdump("The view: '$this->footer' does not exist", __LINE__, "app/View");
				}
			} else {
				Debug::exitdump("The view: '$this->header' does not exist", __LINE__, "app/View");
			}
		} else {
			Debug::exitdump("The view: '". $this->get_view_path($view) ."' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * @param $view
	 *
	 * Does the same as '$this->show([VIEW])'
	 * but this naming convention is more
	 * readable if used in a view
	 */
	public function extend($view) {
		if (file_exists($this->get_view_path($view))) {
			include_once $this->get_view_path($view);
		} else {
			Debug::exitdump("The view '". $this->get_view_path($view) ."' you are trying to extend does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * @param $view
	 * @param $globals
	 *
	 * This method renders
	 * the requested view
	 * from the controller
	 */
	public function show($view, $globals = null) {
		if (file_exists($this->get_view_path($view))) {
			/**
			 * Configure global variables
			 */
			if (!empty($globals)) {
				$this->globals = $globals;
			}

			$this->render_view($view);

			/**
			 * Requires post request handler
			 * for capturing post requests
			 */
			$this->require_post_request_handler();

			/**
			 * Confirms that everything
			 * has rendered properly
			 */
			$this->rendered = true;
		} else {
			Debug::exitdump("The view '". $this->get_view_path($view) ."' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * Requires standard header file
	 */
	public function require_header() {
		if (file_exists($this->header)) {
			require $this->header;
		} else {
			Debug::exitdump("The view: '$this->header' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * Requires standard footer file
	 */
	public function require_footer() {
		if (file_exists($this->footer)) {
			require $this->footer;
		} else {
			Debug::exitdump("The view: '$this->footer' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * @param $view
	 *
	 * Renders the content
	 * from the requested view
	 */
	public function render_view($view) {
		if (file_exists($this->get_view_path($view))) {
			require $this->get_view_path($view);
		} else {
			Debug::exitdump("The view: '". $this->get_view_path($view) ."' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * Requires post request handler
	 */
	public function require_post_request_handler() {
		/**
		 * @var String
		 */
		$post_request_handler = "./http/PostRequestHandler.php";

		if (file_exists($post_request_handler)) {
			require $post_request_handler;
		} else {
			Debug::exitdump($post_request_handler."' does not exist", __LINE__, "app/View");
		}
	}

	/**
	 * @param $view
	 * @return String
	 *
	 * returns the content
	 * from the requested view
	 */
	public function get_view_path($view) {
		return $this->basepath.$view.".php";
	}

	/**
	 * @return array
	 *
	 * returns globals array
	 */
	public function get_globals() {
		return $this->globals;
	}
}
