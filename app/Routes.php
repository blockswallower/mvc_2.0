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
	 * @var string
	 * 
	 * 404 controller path
	 */
	public static $FourNullFourPath = './controllers/PageNotFoundController.php';

	/**
	 * @var string
	 *
	 * 404 controller
	 */
	public static $FourNullFourController = 'PageNotFoundController';

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
			$PageNotFoundController = self::$FourNullFourController;
			self::$controller = self::$FourNullFourController;
			
			require self::$FourNullFourPath;
			new $PageNotFoundController;
		}

		$url_controller = ucfirst($url[0])."Controller";
		
		if (self::$controller != self::$FourNullFourController)
			self::$controller = new $url_controller;

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
