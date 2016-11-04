<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

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