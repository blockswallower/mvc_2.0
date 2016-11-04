<?php

class Routes {
    /**
     * @var array
     */
    private $routes;

    public function __construct() {
        /**
         * This array contains all routing
         * information
         *
         * for example: "index" => "IndexController.show",
         */
        $this->routes = [
             "index" => "IndexController.show",
             "template" => "TemplateController.show",
        ];
    }

    /**
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }
}
