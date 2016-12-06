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
         *
         * Endless routing is also allowed:
         *
         * for example: "users/profile" => "ProfileController.show"
         *
         * If you would like the last URI argument to be
         * a argument to your HTTP Request method, add this as the
         * last URI argument:
         *
         * "users/{param} => "ProfileController.show"
         *
         * And add this to your HTTP request method:
         *
         * public function show($[PARAMETER_NAME]) {
         *
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
