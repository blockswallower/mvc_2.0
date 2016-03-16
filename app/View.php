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
}
