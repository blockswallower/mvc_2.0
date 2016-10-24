<?php

class Config {
	/**
	 * This class contains the general
	 * settings for the Snail framework
	 */

	/**
	 * @var array
	 */
	public static $config;
	
	public function __construct() {
		/*
		 * This config array can be accessed 
		 * in every other file
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
			 * Reserved names
			 */
			'STANDARD_CONTROLLER' => "index",
			'STANDARD_RENDERING_METHOD' => 'show'
		);
	}

	/**
	 * @param $key
	 * @return bool
	 *
	 * Returns value from config array
     */
	public static function get($key) {
		/*
		 * @var String
		 */
		$value = self::$config[$key];

		if (isset($value)) {
			return $value;
		}

		Debug::exitdump("Key doesn't exist in config array");
		return false;
	}
}