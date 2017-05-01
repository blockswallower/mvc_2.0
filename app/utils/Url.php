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

use Snail\App\Config\SNAIL;

class Url {
    /**
     * This class will mainly be used
     * to make redirecting easy
     */

    /**
     * Redirect the user to
     * the previous page
     */
    public static function previous() {
        $previous_page = 'javascript://history.go(-1)';

        header("Location:" . $previous_page);
    }

    /**
     * @param $page
     *
     * Redirects the user to a specific page
     */
    public static function redirect($page) {
        header("Location: " . SNAIL::URL . $page);
    }

    /**
     * @param $page
     *
     * Prints an href link to another page
     */
    public static function href($page) {
        echo SNAIL::URL . $page;
    }
}