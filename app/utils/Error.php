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

namespace Snail\App\Utils;

class Error {
    /**
     * @param $message
     *
     * Shows error message
     */
    public static function set_error($message) {
      echo '<script>document.getElementById("error-handler").innerHTML = "<p>'.$message.'</p>";</script>';
    }
}