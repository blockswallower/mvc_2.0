<?php

class View {
	/**
	 * This class is the standard
	 * blueprint for all the other
	 * views
	 */

	/**
	 * @var array global
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
	 * returns a value from the "var" variable
	 * can be used in views like this:
	 *
	 * $this->get([KEY]);
     */
	public function get($key = null) {
		/*
		 * @var String
		 */
		$cur_controller = Controller::return_current_controller();

		if (!empty($this->globals[$cur_controller])) {
			if (!empty($key)) {
				$value = $this->globals[$cur_controller][$key];

				if (!empty($value)) {
					return $value;
				} else {
					Debug::pagedump('The value you are trying to access is empty or NULL', __LINE__, __CLASS__);
				}
			} else {
				Debug::pagedump('Please enter an array key as an argument: $this->get([KEY])', __LINE__, __CLASS__);
			}
		} else {
			Debug::pagedump("No variables has been send from this controller yet: " . ucfirst($cur_controller) . "Controller",
						    __LINE__, __CLASS__);
		}

		return $key;
	}

	/**
	 * @param $view
	 *
	 * This method renders
	 * the requested view
	 * from the controller
	 * with header and footer
	 * included
	 */
	public function show_hf($view) {
		if (file_exists($this->get_view_path($view))) {
			if (file_exists($this->header)) {
				if (file_exists($this->footer)) {
					$this->require_header();
					$this->render_view($view);
					$this->require_footer();
				} else {
					Debug::pagedump("The view: '$this->footer' does not exist");
				}
			} else {
				Debug::pagedump("The view: '$this->header' does not exist");
			}
		} else {
			Debug::pagedump("The view: '". $this->get_view_path($view) ."' does not exist");
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
			Debug::pagedump("The view '". $this->get_view_path($view) ."' you are trying to extend
							 does not exist");
		}
	}

	/**
	 * @param $view
	 *
	 * This method renders
	 * the requested view
	 * from the controller
	 */
	public function show($view) {
		if (file_exists($this->get_view_path($view))) {
			$this->render_view($view);
		} else {
			Debug::pagedump("The view '". $this->get_view_path($view) ."' does not exist");
		}
	}

	/**
	 * Requires standard header file
	 */
	public function require_header() {
		if (file_exists($this->header)) {
			require $this->header;
		} else {
			Debug::pagedump("The view: '$this->header' does not exist");
		}
	}

	/**
	 * Requires standard footer file
	 */
	public function require_footer() {
		if (file_exists($this->footer)) {
			require $this->footer;
		} else {
			Debug::pagedump("The view: '$this->footer' does not exist");
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
			Debug::pagedump("The view: '". $this->get_view_path($view) ."' does not exist");
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
