<?php

class PageNotFoundController extends Controller {
	public function __construct() {
		parent::__construct();
		
		/**
		 * Render the correct
		 * content based on the
		 * parameter
		 */
		$this->view->show_hf('404/404');
	}
}