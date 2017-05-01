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

class View {
    /**
     * @var string
     * Path to the controllers folder
     */
    private $path_to_controllers = './controllers/';

    /**
     * @var string
     * Path to the views folder
     */
    private $path_to_views = './views/';

    /**
     * @var bool
     * Will be true on the first
     * show/extend/show_hf execution
     */
    private $rendered = false;

    public function __construct($route = null, $param = null) {
        if ($route !== null) {
            /* Build the controller name with provided route */
            $controller_name = ucfirst($route) . 'Controller';

            /* Check if the controller exists */
            $complete_path = $this->path_to_controllers . $controller_name . '.php';
            if (!file_exists($complete_path)) {
                Debug::fatal("Controller: '$controller_name' does not exist");
            }

            /* Require the controller */
            require_once $complete_path;

            /* Render the view */
            $object = new $controller_name();

            if ($param !== null) {
                /* Execute show method with provided $param var */
                $object->show($param);
            } else {
                /* Execute show method without parameters */
                $object->show();
            }
        }
    }

    /**
     * @param $view_name string
     *
     * Method to render a view from the
     * views folder.
     *
     * Usage: $this->view->show([VIEW])
     */
    public function show($view_name) {
        /* Add PHP extension to view name */
        $view = strtolower($view_name) . '.php';

        $complete_path = $this->path_to_views . $view;
        if (!file_exists($complete_path)) {
            Debug::fatal("View: '$view_name' not found");
        }

        /* Require the view */
        require_once $complete_path;

        /* Set rendered to true */
        if (!$this->rendered) {
            $this->rendered = true;
        }
    }

    /**
     * @param $view_name
     *
     * Method for rendering a view with header
     * and footer file attached
     *
     * Usage: $this->view->show_hf([VIEW])
     */
    public function show_hf($view_name) {
        /* Add PHP extension to view name */
        $view = strtolower($view_name) . '.php';

        $complete_path = $this->path_to_views . $view;
        if (!file_exists($complete_path)) {
            Debug::fatal("View: '$view_name' not found");
        }

        if (!file_exists(SNAIL::HEADER)) {
            $header = SNAIL::HEADER;
            Debug::fatal("View: '$header' not found");
        }

        if (!file_exists(SNAIL::FOOTER)) {
            $footer = SNAIL::FOOTER;
            Debug::fatal("View: '$footer' not found");
        }

        /* Require the header */
        require_once SNAIL::HEADER;

        /* Require the view */
        require_once $complete_path;

        /* Require the footer */
        require_once SNAIL::FOOTER;

        /* Set rendered to true */
        if (!$this->rendered) {
            $this->rendered = true;
        }
    }
}