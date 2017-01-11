<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

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
		self::$config = array(
			/**
			 * Application information
			 */
			'APP_NAME' => 'Snail - PHP framework',
			'APP_VERSION' => "0.6.1",
			'APP_LANGUAGE' => 'en',
			'APP_MAIL' => 'info@snailframework.com',

			/**
			 * Debug
			 */
			'DEBUG' => true,

			/**
			 * Csrf
			 *
			 * If this value is true a csrf token
			 * must be provided when the form submits
			 */
			'CSRF' => false,

			/**
			 * Database
			 */
			'DB_TYPE' => 'mysql',
			'DB_HOST' => 'localhost',
			'DB_NAME' => '',
			'DB_USERNAME' => 'root',
			'DB_PASSWORD' => '',

			/**
			 * Scripts
			 */
			'SCRIPT' => array(
				'EVERY_TIME_EXECUTION' => 'NONE',
				'ONE_TIME_EXECUTION' => 'NONE'
			),

			/**
			 * Reserved names
			 */
			'STANDARD_CONTROLLER' => "index",
			'STANDARD_RENDERING_METHOD' => 'show',
			'STANDARD_MULTIPLE_FORM_NAME' => "multforms"
		);
	}

	/**
	 * @param $key
	 * @return bool
	 *
	 * Returns value from config array
     *
     * Use: Config::get([KEY])
     */
	public static function get($key) {
		/**
		 * @var String
		 */
		$value = self::$config[$key];

		if (isset($value)) {
			return $value;
		}

		Debug::exitdump("Key doesn't exist in config array: '$key'", __LINE__, "app/Config");
		return false;
	}
}