<?php

class Application {
    public $controller;

    public function __construct() {
        /**
         * Generates the URL in the right format
         */
        $url = $this->get_url();

        /**
         * Validates if the URL is not empty
         */
        $this->validate_url($url);

        $this->controller = "controllers/$url[0].php";
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
     */
    public function validate_url($url) {
        if (empty($url[0])) {
            require 'controllers/IndexController.php';
            $this->controller = new IndexController();
        }
    }
}