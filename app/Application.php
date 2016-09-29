<?php

class Application {
    /**
     * This Application class is in control
     * of all the routing and url handling
     *
     * NOTE: Editing this file might corrupt
     * the overall functionality
     */

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $file;

    /**
     * @var string
     */
    public $standard_controller;

    public function __construct() {
        $this->standard_controller = "controllers/"
                                     .ucfirst(Settings::$config["STANDARD_CONTROLLER"]) . "Controller.php";

        /**
         * Generates the URL in the right format
         */
        $url = $this->get_url();

        /**
         * Validates if the URL is not empty
         */
        if (!$this->validate_url($url)) {
            $url_controller = ucfirst($url[0])."Controller.php";
            $this->file = "controllers/$url_controller";
            /**
             * Routes to the right view
             * based on the url
             */
            Routes::route($url, $this->file);
        } else {
            require_once "Urls.php";
            $url_permission = new Urls();

            /*
			 * Check if the user has permission
			 * to enter the page.
			 */
            if (in_array(Settings::$config["STANDARD_CONTROLLER"], $url_permission->urls)) {
                require $this->standard_controller;
                $this->controller = new IndexController();
            } else {
                Debug::exitdump("You have no permission to enter this page: " . Settings::$config["STANDARD_CONTROLLER"]);
            }
        }
    }

    /**
     * @return array|mixed|null|string
     */
    public function get_url() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        return $url;
    }

    /**
     * @param $url
     * @return bool
     */
    public function validate_url($url) {
        if (empty($url[0])) {
            return true;
        } else {
            return false;
        }
    }
}