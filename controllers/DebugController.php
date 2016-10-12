<?php

class DebugController extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function show() {
		/**
		 * Render the correct
		 * content based on the
		 * parameter
		 */
		$this->view->show('debug/debug');
	}
}