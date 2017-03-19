<?php

class HttpstatusController extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function show($httpcode) {
		/*
 	     * Set http code
 	     */
		$this->set('httpstatus', 'httpcode', $httpcode);

		/*
         * Set status message
          */
		$this->set('httpstatus', 'statusMessage', $this->getStatusMessage($httpcode));

		/**
		 * Render the correct
		 * content based on the
		 * parameter
		 */
		$this->view->show_hf('httpstatus/httpstatus', $this->globals);
	}

	/**
	 * @param $httpcode
	 * @return $message
     */
	public function getStatusMessage($httpcode) {
		switch($httpcode) {
			/*
			 * Client errors
			 */
			case 400:
				$message = 'Bad Request';
				break;
			case 401:
				$message = 'Unauthorized';
				break;
			case 402:
				$message = 'Payment Required';
				break;
			case 403:
				$message = 'Forbidden';
				break;
			case 404:
				$message = 'Not Found';
				break;
			case 405:
				$message = 'Method Not Allowed';
				break;

			/*
			 * Default case
			 */
			default:
				$message = 'OK';
		}

		return $message;
	}
}