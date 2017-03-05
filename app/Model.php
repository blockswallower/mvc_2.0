<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Model {
    protected $db;

    public function __construct() {
        /**
         * Sets up the database
         * for every other child model
         */
        $this->db = new Database();
    }
}