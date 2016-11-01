<?php

class Routes {
    /*
     * @var Array
     */
    private $routes;

    public function __construct() {
        /*
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

    /*
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }
}
