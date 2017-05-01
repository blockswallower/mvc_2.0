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

use Snail\App\Utils\Session;

class Bootstrap {
    public function __construct() {
        /* Redirecting after a function call */
        ob_start();

        /* Start a session */
        Session::init();

        /* Configure the routes */
        require_once 'http/Routes.php';

        /* Perform the route */
        $router->route();
    }
}