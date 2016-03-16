<?php

class Settings {
	/**
	 * This class contains the general
	 * settings for the application
	 */

	/**
	 * @var array
	 */
	public $config;
	
	public function __construct() {
		/**
		 * This config array can be accessed 
		 * in the other controllers
		 * 
		 * access in controllers:
		 * $this->settings->config[ARRAY_INDEX]
		 */
		$this->config = array(
			
		);
	}
}