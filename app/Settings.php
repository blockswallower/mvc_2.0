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

			'DB_TYPE' => 'mysql',
			'DB_HOST' => 'localhost',
			'DB_NAME' => '',
			'DB_USERNAME' => 'root',
			'DB_PASSWORD' => '',

			'SCRIPT' => array(
				'EVERY_TIME_EXECUTION' => 'NONE',
				'ONE_TIME_EXECUTION' => 'NONE'
			),

			'STANDARD_CONTROLLER' => "index"
		);
	}
}