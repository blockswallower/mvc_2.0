<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Router {
    /*
     * This variable will be the key for
     * the Router to understand incoming Ajax
     * requests
     */
    private $ajax_keyword = 'ajax';

    private $httpstatus_controller = "HttpstatusController";

    private $httpstatus_rendering_method = "show";

    public function __construct() {
        require './http/Routes.php';

        $routes = new Routes();

        $url = $this->get_url();
        $route = $this->get_route($url);

        if (!empty($route)) {
            $split = explode("/", $route);

            if ($split[0] === $this->ajax_keyword) {
                /*
                 * Handle Ajax Requests (Only if the first URL index equals the Ajax keyword)
                 */
                $this->handle_ajax_request($split);
            } else {
                $route_with_params = str_replace(Arr::last($split), "{param}", $route);

                if (!empty($routes->getRoutes()[$route_with_params])) {
                    /*
                     * Route to page with last URL index as parameter
                     */
                    $param = Arr::last($split);
                    $this->route($routes->getRoutes()[$route_with_params], $param);
                } else {
                    if (!empty($routes->getRoutes()[$route])) {
                        /*
                         * Route to page without parameters
                         */
                        $this->route($routes->getRoutes()[$route]);
                    } else {
                        $this->throw404();
                    }
                }
            }
        } else {
            $this->render_standard_page();
        }
    }

    /**
     * @param $param
     * @param $route
     *
     * This method routes the user based on http/Routes.php
     */
    private function route($route = null, $param = null) {
        if (is_callable($route)) {
            /**
             * If the $controller variable
             * is a closure, run it
             */
            $route();
        } else {
            if (strstr($route, ".")) {
                $split_route = explode(".", $route);
                $controller = $split_route[0];
                $method = $split_route[1];

                /**
                 * Check if controller exists
                 */
                if (!file_exists('controllers/' . $controller . '.php')) {
                    Debug::exitdump('controllers/' . $controller . '.php does not exist!', __LINE__, "app/Router");
                } else {
                    require 'controllers/' . $controller . '.php';
                    $object = new $controller;

                    /*
                     * Check if method exists in $controller
                     */
                    if (method_exists($object, $method)) {
                        if ($param !== null) {
                            if (!$this->has_parameters($object, $method)) {
                                Debug::exitdump("No parameter found! Be sure to add your parameter in '$controller.$method'", __LINE__,  "app/Router");
                            }

                            $object->$method($param);
                        } else {
                            if ($this->has_parameters($object, $method)) {
                                Debug::exitdump("Undefined parameter(s) found in '$controller.$method'", __LINE__,  "app/Router");
                            }

                            $object->$method();
                        }
                    } else {
                        Debug::exitdump("The method '$method' does not exist in '$controller'!", __LINE__, "app/Router");
                    }
                }
            }
        }
    }

    /**
     * @param $url
     *
     * Handles Ajax requests
     */
    private function handle_ajax_request($url) {
        if (IS_AJAX) {
            $controller = $url[0];

            if (!empty($url[1])) {
                $method = $url[1];
            }

            if (!empty($controller)) {
                $this->run_ajax_method($controller, $method);
            }
        } else {
            if (Config::get("DEBUG")) {
                Debug::exitdump("No permission!", __LINE__, 'app/Router');
            } else {
                $this->throw404();
            }
        }
    }

    /**
     * @param $url
     * @return String
     *
     * Return the route the user is trying to
     * access (String)
     */
    private function get_route($url) {
        if (Arr::size($url) > 2) {
            $route = '';

            for ($ii  = 2; $ii < Arr::size($url); $ii++) {
                $slash =  Arr::last($url) == $url[$ii] ? "" : "/";
                $route .= $url[$ii] . $slash;
            }
        } else {
            $route = $url[2];
        }

        return $route;
    }

    /*
     * Renders an httpstatus page with 404 httpcode
     */
    private function throw404() {
        require 'controllers/' . $this->httpstatus_controller . ".php";

        $method = $this->httpstatus_rendering_method;

        $controller = new $this->httpstatus_controller();
        $controller->$method(404);
    }

    /*
     * Renders standard page. (Defined in app/Config.php)
     */
    private function render_standard_page() {
        $standard_controller = ucfirst(Config::get("STANDARD_CONTROLLER")) . "Controller";
        require 'controllers/' . $standard_controller . '.php';

        $controller = new $standard_controller;
        $rendering_method = Config::get("STANDARD_RENDERING_METHOD");

        $controller->$rendering_method();
    }


    /**
     * @param $controller
     *
     * Executes AjaxController method send from ajax
     */
    private function run_ajax_method($controller, $method) {
        if (file_exists('controllers/ajax/' . ucfirst($controller) . 'Controller.php')) {
            $controller = ucfirst($controller) . 'Controller';
            require 'controllers/ajax/' . $controller . '.php';

            $ajax = new $controller();

            if (!empty($method)) {
                if (method_exists($ajax, $method)) {
                    $ajax->$method();
                }
            }
        }
    }

    /**
     * @param $controller
     * @param $method
     * @return bool
     *
     * Returns true or false based on if the
     * given method has parameters.
     */
    private function has_parameters($controller, $method) {
        $hasParameters = false;
        $reflector = new ReflectionMethod($controller, $method);

        if (!empty($reflector->getParameters())) {
            $hasParameters = true;
        }

        return $hasParameters;
    }

    /**
     * @return array
     */
    public static function get_url() {
        $split = explode("/", $_SERVER['REQUEST_URI']);

        if (!empty(Arr::last($split))) {
            if (Str::contains(Arr::last($split), ["?", "="], true)) {
                $strsplit = str_split(Arr::last($split));
                $question_mark_index = Arr::find_index($strsplit, "?");

                $cut_string = Str::substringint(Arr::last($split), 0, $question_mark_index - 1);
                $last_item_index = Arr::find_index($split, Arr::last($split));

                $split[$last_item_index] = $cut_string;
            }
        }

        return $split;
    }
}
