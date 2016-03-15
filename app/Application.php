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

        $this->route($url, $this->file);
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
            require 'controllers/index.php';
            $this->controller = new index();
        }
    }

    /**
     * @param $url
     * @param $file
     * @return bool
     */
    public function route($url, $file) {
        if (file_exists($file)) {
            require $file;
        } else {
            return false;
        }

        $this->controller = new $url[0];

        if (isset($url[2])) {
            if (method_exists($this->controller, $url[1])) {
                $this->controller->{$url[1]}($url[2]);
            } else {
                return false;
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->controller->{$url[1]}();
                } else {
                    return false;
                }
            }
        }
    }
}