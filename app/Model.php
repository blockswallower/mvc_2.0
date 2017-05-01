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

use BITbuilder\core\Builder;
use Snail\App\Database;

class Model {
    /**
     * $b @object
     *
     * This variable will contain the
     * BITbuilder object
     */
    public $b;

    /**
     * $db @object
     *
     * This variable will contain the
     * PDO database object
     */
    public $db;

    public function __construct() {
        /* Instantiate the PDO object */
        $this->db = new Database();

        /* Instantiate the BITbuilder object */
        $this->b = new Builder($this->db);
    }
}