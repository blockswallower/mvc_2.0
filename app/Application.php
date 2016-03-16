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

    public function __construct() {
        /**
         * Generates the URL in the right format
         */
        $url = $this->get_url();

        /**
         * Validates if the URL is not empty
         */
        $this->validate_url($url);

        $this->file = "controllers/$url[0].php";

        /**
         * Routes to the right view 
         * based on the url
         */
        Routes::route($url, $this->file);
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
     * 
     * Requires the standard 
     * index controller/view 
     * if the url[0] is empty
     */
    public function validate_url($url) {
        if (empty($url[0])) {
            require 'controllers/index.php';
            $this->controller = new index();
        }
    }
}