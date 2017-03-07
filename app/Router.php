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

    private $page_not_found_controller = "PageNotFoundController";

    private $page_not_found_rendering_method = "show";

    public function __construct() {
        require './http/Routes.php';

        $routes = new Routes();
        $url = $this->get_url();

        if (Arr::size($url) > 2) {
            $current_page = '';

            for ($ii  = 2; $ii < Arr::size($url); $ii++) {
                $slash =  Arr::last($url) == $url[$ii] ? "" : "/";
                $current_page .= $url[$ii] . $slash;
            }
        } else {
            $current_page = $url[2];
        }

        if (!empty($current_page)) {
            /**
             * check if the last value needs to be passed
             * in to the rendering method as parameter
             */
            $split = explode("/", $current_page);

            /*
             * Handle Ajax Requests (Only if the first URL item equals the Ajax recognizer)
             */
            if ($split[0] == $this->ajax_keyword) {
                $this->handle_ajax_request($split);
            } else {
                /*
                 * Handle regular url GET request
                 */
                $temp_current_page = str_replace(Arr::last($split), "{param}", $current_page);

                if (!empty($routes->getRoutes()[$temp_current_page])) {
                    $param = Arr::last($split);

                    $this->http($routes->getRoutes()[$temp_current_page], $param);
                } else {
                    if (!empty($routes->getRoutes()[$current_page])) {
                        /**
                         * Route to the correct view
                         */
                        $this->http($routes->getRoutes()[$current_page]);
                    } else {
                        require 'controllers/' . $this->page_not_found_controller . ".php";

                        $method = $this->page_not_found_rendering_method;

                        $controller = new $this->page_not_found_controller();
                        $controller->$method();
                    }
                }
            }
        } else {
            if (!isset($standard_controller)) {
                /**
                 * Replace with standard controller
                 */
                $standard_controller = ucfirst(Config::get("STANDARD_CONTROLLER")) . "Controller";
                require 'controllers/' . $standard_controller . '.php';

                $controller = new $standard_controller;
                $rendering_method = Config::get("STANDARD_RENDERING_METHOD");

                $controller->$rendering_method();
            }
        }
    }

    /**
     * @param null $controller
     *
     * This method routes the user based on http/Routes.php
     */
    private function http($controller = null, $param = null) {
        /**
         * If the $controller parameter
         * is a callable function run it
         */
        if (is_callable($controller)) {
            $controller();
        } else {
            if (strstr($controller, ".")) {
                $split = explode(".", $controller);

                /**
                 * Checks if given controller exists
                 */
                if (!file_exists('controllers/' . $split[0] . '.php')) {
                    Debug::exitdump('controllers/' . $split[0] . '.php does not exist!', __LINE__, "app/Router");
                } else {
                    require 'controllers/' . $split[0] . '.php';

                    $controller = new $split[0];

                    if (method_exists($controller, $split[1])) {
                        /**
                         * Executes given method
                         */
                        if ($param !== null) {
                            /**
                             * An reflection class
                             * to check if the given method
                             * has parameters
                             */
                            $method = new ReflectionMethod($controller, $split[1]);

                            if (empty($method->getParameters())) {
                                Debug::exitdump("No parameter found! Be sure to add your parameter in '$split[0].$split[1]'",
                                                 __LINE__,  "app/Router");
                            }

                            $controller->$split[1]($param);
                        } else {
                            /**
                             * An reflection class
                             * to check if the given method
                             * has parameters
                             */
                            $method = new ReflectionMethod($controller, $split[1]);

                            if (!empty($method->getParameters())) {
                                Debug::exitdump("Undefined parameter(s) found in '$split[0].$split[1]'", __LINE__,  "app/Router");
                            }

                            $controller->$split[1]();
                        }
                    } else {
                        Debug::exitdump("The method '$split[1]' does not exist in '$split[0]'!", __LINE__, "app/Router");
                    }
                }
            } else {
                require 'controllers/' . $controller . '.php';
                $controller = new $controller;
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
        } else {
            if (Config::get("DEBUG")) {
                Debug::exitdump("No permission!", __LINE__, 'app/Router');
            } else {
                require 'controllers/' . $this->page_not_found_controller . ".php";

                $method = $this->page_not_found_rendering_method;

                $controller = new $this->page_not_found_controller();
                $controller->$method();
            }
        }
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
