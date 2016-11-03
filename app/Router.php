<?php

class Router {
    /*
     * This class handles routing
     */
    public function __construct() {
        require './http/Routes.php';

        /*
         * @var Object
         */
        $routes = new Routes();

        /*
         * @var Array
         */
        $url = $this->get_url();

        if (Arr::size($url) > 2) {
            /*
             * @var String
             */
            $current_page = '';

            for ($ii  = 2; $ii < Arr::size($url); $ii++) {
                /*
                 * @var String
                 */
                $slash =  Arr::last($url) == $url[$ii] ? "" : "/";

                $current_page .= $url[$ii] . $slash;
            }
        } else {
            /*
             * @var String
             */
            $current_page = $url[2];
        }

        /*
         * @var String
         */
        $page_not_found_controller = "PageNotFoundController";

        /*
         * @var String
         */
        $page_not_found_rendering_method = "show";

        if (!empty($current_page)) {
            /*
             * check if the last value needs to be passed
             * in to the rendering method as parameter
             *
             * @var Array
             */
            $split = explode("/", $current_page);

            /*
             * @var Array
             */
            $temp_current_page = str_replace(Arr::last($split), "{param}", $current_page);

            if (!empty($routes->getRoutes()[$temp_current_page])) {
                /*
                 * @var String
                 */
                $param = Arr::last($split);

                $this->http($routes->getRoutes()[$temp_current_page], $param);
            } else {
                if (!empty($routes->getRoutes()[$current_page])) {
                    /*
                     * Route to the correct view
                     */
                    $this->http($routes->getRoutes()[$current_page]);
                } else {
                    require 'controllers/' . $page_not_found_controller . ".php";
                    /*
                     * @var Object
                     */
                    $controller = new $page_not_found_controller();

                    /*
                     * Renders 404 page
                     */
                    $controller->$page_not_found_rendering_method();
                }
            }
        } else {
            if (!isset($standard_controller)) {
                /*
                 * Replace with standard controller
                 */
                $standard_controller = ucfirst(Config::get("STANDARD_CONTROLLER")) . "Controller";

                require 'controllers/' . $standard_controller . '.php';

                /*
                 * @var Object
                 */
                $controller = new $standard_controller;

                /*
                 * @var String
                 */
                $rendering_method = Config::get("STANDARD_RENDERING_METHOD");

                /*
                 * Render view
                 */
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
        /*
         * If the $controller parameter
         * is a callable function run it
         */
        if (is_callable($controller)) {
            $controller();
        } else {
            if (strstr($controller, ".")) {
                /*
                 * @var Array
                 */
                $split = explode(".", $controller);

                /*
                 * Checks if given controller exists
                 */
                if (!file_exists('controllers/' . $split[0] . '.php')) {
                    Debug::exitdump('controllers/' . $split[0] . '.php does not exist!', __LINE__, "app/Router");
                } else {
                    require 'controllers/' . $split[0] . '.php';

                    /*
                     * @var Object
                     */
                    $controller = new $split[0];

                    /*
                     * Checks if method exists
                     */
                    if (method_exists($controller, $split[1])) {
                        /*
                         * Executes given method
                         */
                        if ($param !== null) {
                            $controller->$split[1]($param);
                        } else {
                            $controller->$split[1]();
                        }
                    } else {
                        Debug::exitdump("The method '$split[1]' does not exist in '$split[0]'!", __LINE__, "app/Router");
                    }
                }
            } else {
                require 'controllers/' . $controller . '.php';

                /*
                 * @var Object
                 */
                $controller = new $controller;
            }
        }
    }

    /**
     * @return array
     */
    public static function get_url() {
        /*
         * @var Array
         */
        $split = explode("/", $_SERVER['REQUEST_URI']);

        if (!empty(Arr::last($split))) {
            if (Str::contains(Arr::last($split), ["?", "="], true)) {
                /*
                 * @var Array
                 */
                $strsplit = str_split(Arr::last($split));

                /*
                 * @var Integer
                 */
                $question_mark_index = Arr::find_index($strsplit, "?");

                /*
                 * @var String
                 */
                $cut_string = Str::substringint(Arr::last($split), 0, $question_mark_index - 1);

                /*
                 * @var Integer
                 */
                $last_item_index = Arr::find_index($split, Arr::last($split));

                $split[$last_item_index] = $cut_string;
            }
        }

        return $split;
    }
}
