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
	public $var;

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
	 * This method renders
	 * the requested view
	 * from the controller
	 */
	public function show($view) {
		$this->require_header();
		$this->render_view($view);
		$this->require_footer();
	}

	/**
	 * Requires standard header file
     */
	public function require_header() {
		require $this->header;
	}

	/**
	 * Requires standard footer file
     */
	public function require_footer() {
		require $this->footer;
	}

	/**
	 * Renders the content
	 * from the requested view
	 */
	public function render_view($view) {
		require $this->basepath.$view.".php";
	}

	/**
	 * @param null $key
	 * @return mixed
	 *
	 * returns a value from the view "var" variable
	 * can be used in views like this:
	 *
	 * $this->get([KEY]);
     */
	public function get($key = null) {
		/*
		 * @var String
		 */
		$cur_controller = Controller::return_current_controller();

		if (!empty($this->var[$cur_controller])) {
			if (!empty($key)) {
				$value = $this->var[$cur_controller][$key];

				if (!empty($value)) {
					return $value;
				} else {
					debug::pagedump('The value you are trying to access is empty or NULL');
				}
			} else {
				debug::pagedump('Please enter a value as an argument: $this->get([VALUE])');
			}
		} else {
			debug::pagedump("No variables has been send to this controller yet: " . ucfirst($cur_controller) . "Controller");
		}

		return $key;
	}
}
