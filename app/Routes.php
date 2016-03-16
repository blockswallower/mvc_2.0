<?php 

class Routes {
	/**
	 * This class is in control
	 * of Routing to the correct 
	 * controller/view
	 */
	
	/**
	 * @var string
	 */
	public static $controller;

	/**
	 * @param $url
	 * @param $file
	 * @return bool
	 */
	public static function route($url, $file) {
		if (file_exists($file)) {
			/**
			 * If the file exists 
			 * the file gets required
			 */
			require $file;
		} else {
			return false;
		}
		
		self::$controller = new $url[0];

		if (isset($url[2])) {
			if (method_exists(self::$controller, $url[1])) {
				self::$controller->{$url[1]}($url[2]);
			} else {
				return false;
			}
		} else {
			if (isset($url[1])) {
				if (method_exists(self::$controller, $url[1])) {
					self::$controller->{$url[1]}();
				} else {
					return false;
				}
			}
		}
	}
}
