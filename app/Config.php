<?php

class Config {
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
		 *
		 * Config::$config[KEY]
		 *
		 * or
		 *
		 * Config::get(KEY)
		 *
		 */
		self::$config = array(
			/*
			 * Application information
			 */
			'APP_NAME' => 'Snail - PHP framework',
			'APP_VERSION' => 0.5,
			'APP_LANGUAGE' => 'en',
			'APP_MAIL' => 'info@snailframework.com',

			/*
			 * Debug
			 */
			'DEBUG' => true,

			/*
			 * Database
			 */
			'DB_TYPE' => 'mysql',
			'DB_HOST' => 'localhost',
			'DB_NAME' => '',
			'DB_USERNAME' => 'root',
			'DB_PASSWORD' => '',

			/*
			 * Scripts
			 */
			'SCRIPT' => array(
				'EVERY_TIME_EXECUTION' => 'NONE',
				'ONE_TIME_EXECUTION' => 'NONE'
			),

			/*
			 * Reserved file names
			 */
			'STANDARD_CONTROLLER' => "index"
		);
	}

	/**
	 * @param $key
	 * @return bool
	 *
	 * returns value from config array
     */
	public static function get($key) {
		if (isset(self::$config[$key])) {
			return self::$config[$key];
		}

		Debug::exitdump("Key doesn't exist in config array");
		return false;
	}
}