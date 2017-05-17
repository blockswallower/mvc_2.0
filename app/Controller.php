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

use Snail\App\View;
use Snail\App\Utils\Debug;
use Snail\App\Utils\X;

class Controller {
    /**
     * @var object
     * Model object
     */
    protected $model;

    /**
     * @var object
     * View object
     */
    protected $view;

    public function __construct() {
        /* Array that contains every variable send to the actual views */
        $this->globals = [];

        /* View object used to render PHP views */
        $this->view = new View();
    }

    /**
     * @param $key
     * @param $value
     *
     * Sets a view variable
     * access: $this->[VARIABLE_NAME]
     */
    public function set($key, $value) {
        /* Make sure only string variables can be used as variable names*/
        if (!is_string($key)) {
            Debug::fatal("'$key' can't be used as variable name, please provide a string");
        }

        /* Decode the value to prevent XSS */
        $value = X::decode($value);

        /* "Send" the variable to the view */
        $this->view->{$key} = $value;
    }

    /**
     * @param $model_name
     *
     * Loads the model with the provided
     * parameter as model name
     *
     * Controller:
     *
     * $this->load_model('index');
     * $this->index->[FUCTION_CALL]
     */
    public function load_model($model_name) {
        $model = ucfirst($model_name) . "Model";

        /* Path to models */
        $path_to_models = './models/';

        $complete_path = $path_to_models . $model . '.php';
        if (file_exists($complete_path)) {
            /* Require the model */
            require_once $complete_path;

            /* Create the model */
            $this->{$model_name} = new $model();
        } else {
            Debug::fatal('models/' . $model . ".php doesn't exist");
        }
    }
}