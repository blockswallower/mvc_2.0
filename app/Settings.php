<?php

class Settings {
	/**
	 * This class contains the general
	 * settings for the application
	 */

	/**
	 * @var array
	 */
	public static $config;
	
	public function __construct() {
		/**
		 * This config array can be accessed 
		 * in the other controllers
		 * 
		 * access in other PHP files:
		 * Settings::$config[ARRAY_INDEX]
		 */
		self::$config = array(
			'DEBUG' => true,

			'SCRIPT' => array(
				'FILES' => 'NONE',
				'ONE_TIME_EXECUTION' => true
			),
		);
	}
}