<?php

/**
 * =================================================================
 * @package Snail
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2017 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers/Snail
 * @license Open Source MIT license
 * =================================================================
 */

namespace Snail\App;

use Snail\App\Config\SNAIL;
use Snail\App\Utils\Debug;
use Snail\App\Utils\Arr;
use Snail\App\Utils\Req;
use Snail\App\Utils\Str;

class Router {
    /**
     * @var array
     *
     * This array will contain every route
     * configured in http/Routes.php. A route
     * can be configured with the 'get' method:
     *
     * $router->get('test', function() {
     *      return new View('test');
     * });
     */
    private $routes = [];

    /**
     * @var mixed
     *
     * This variable will contain the provided
     * {param}. $param can be accessed by calling the
     * Router::get_param() method in your Router.php
     * file.
     */
    private static $param;

    /**
     * @param $closure
     * @return bool
     *
     * Configures the '/' route. This route
     * will be used as default
     */
    public function base($closure) {
        /* Check if the second parameter is a Closure */
        if (!is_callable($closure)) {
            Debug::dump("Please enter a closure (anonynous function) as parameter");
            return false;
        }

        /* Configure the base route */
        $this->routes['GET']['/'] = $closure;
    }

    /**
     * @param $route string
     * @param $closure \Closure
     * @return bool
     *
     * get is used to 'configure' a get route. Every configured get route
     * gets stored in the $routes['GET'] array.
     */
    public function get($route, $closure) {
        /* Check if the route has already been configured */
        if (isset($this->routes['GET'][$route])) {
            Debug::dump("Route: '$route' has allready been configured");
            return false;
        }

        /* Check if the second parameter is a Closure */
        if (!is_callable($closure)) {
            Debug::dump("Please enter a closure (anonynous function) as second parameter");
            return false;
        }

        /* Configure the route */
        $this->routes['GET'][$route] = $closure;
    }

    /**
     * @param $route string
     * @param $closure \Closure
     * @return bool
     *
     * post is used to 'configure' a post route. Every configured post route
     * gets stored in the $routes['POST'] array.
     */
    public function post($route, $closure) {
        /* Check if the route has already been configured */
        if (isset($this->routes['POST'][$route])) {
            Debug::dump("Route: '$route' has allready been configured");
            return false;
        }

        /* Check if the second parameter is a Closure */
        if (!is_callable($closure)) {
            Debug::dump("Please enter a closure (anonynous function) as second parameter");
            return false;
        }

        /* Configure the route */
        $this->routes['POST'][$route] = $closure;
    }

    /**
     * @return bool
     *
     * Performs the route
     */
    public function route() {
        $route = $this->get_route();

        /* Find the request method */
        $request = $_SERVER['REQUEST_METHOD'];
        if (!empty($route)) {
            /* Split the route on the slashes */
            $split_route = explode("/", $route);
            if (count($split_route) > 1) {
                /* Store the parameter */
                $param = Arr::last($split_route);

                /* Remove the last URL key */
                unset($split_route[Arr::last_index($split_route)]);

                $route_with_param = '';
                foreach($split_route as $route) {
                    $route_with_param .= $route . '/';
                }

                /* Append the {param} keyword to the route */
                $route_with_param .= '{param}';
                $route .= "/$param";
            }
        }

        /* Set the route to '/' if there are no routes found */
        if (empty($route)) {
            $route = '/';
        }

        if (isset($this->routes[$request][$route])) {
            /* Execute the closure */
            $closure = $this->routes[$request][$route];
            $closure();

            return true;
        } else if (isset($this->routes[$request][$route_with_param])) {
            /* Set the static $param variable */
            self::set_param($param);

            /* Execute the closure */
            $closure = $this->routes[$request][$route_with_param];
            $closure();

            return true;
        } else {
            Debug::dump("Route not found");
            return false;
        }
    }

    /**
     * @param $controller
     * @param $method
     * @return bool
     *
     * Executes the provided method on a specific
     * form submit
     */
    public static function form_action($controller, $method) {
        if (SNAIL::CSRF) {
            /* Make sure there is an csrf token provided */
            $token = Req::post("csrf_token");

            if (empty($token)) {
                Debug::fatal("Make sure to add an csrf token to your form");
            }
        }

        /* Path to controllers */
        $path_to_controllers = './controllers/';

        /* Require the controller */
        $complete_path = $path_to_controllers . $controller . '.php';
        if (file_exists($complete_path)) {
            require_once $complete_path;
        }

        /* Instantiate the controller */
        $object = new $controller();

        if (method_exists($object, $method)) {
            /* Execute the provided method */
            $object->$method();
        }
    }

    /**
     * @return array
     *
     * Returns the url in an assoc array format
     */
    public function get_url() {
        /* Split the url on the slashes */
        $split = explode("/", $_SERVER['REQUEST_URI']);

        /* Remove the GET variables */
        $split = $this->manage_GET_variables($split);

        return $split;
    }

    /**
     * @return mixed|string
     *
     * Returns route needed for mapping
     */
    public function get_route() {
        $url = $this->get_url();
        $route = '';

        /* Check if we need to handle endless routing */
        if (isset($url[3])) {
            foreach ($url as $key => $value) {
                if ($key >= 2) {
                    if ($key !== Arr::last_index($url)) {
                        $route .= $value . '/';
                    } else {
                        $route .= $value;
                    }
                }
            }
        } else {
            /* There is just 1 route */
            $route = $url[2];
        }

        return $route;
    }

    /**
     * @param $split array
     * @return array
     *
     * Removes the the GET variables from the url
     * so that they don't interfere with the routing
     * process
     */
    private function manage_GET_variables($split) {
        if (!empty(Arr::last($split))) {
            /* Check if the url contains GET variables*/
            if (Str::contains(Arr::last($split), ["?", "="], true)) {
                /* Turn the last key off the url into a char array */
                $strsplit = str_split(Arr::last($split));

                /* Find the ? */
                $question_mark_index = Arr::find_index($strsplit, "?");

                /* Cut the key in a way that the GET variables aren't included */
                $cut_string = Str::substringint(Arr::last($split), 0, $question_mark_index - 1);
                $last_item_index = Arr::find_index($split, Arr::last($split));

                $split[$last_item_index] = $cut_string;
            }
        }

        return $split;
    }


    /**
     * @param $param
     *
     * Sets the param
     */
    private static function set_param($param) {
        self::$param = $param;
    }

    /**
     * @return mixed
     */
    public static function get_param() {
        return self::$param;
    }
}