<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

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
        /**
         * @var string
         */
        $previous_page = 'javascript://history.go(-1)';

        header("Location:" . $previous_page);
    }

    /**
     * @param $page
     *
     * Redirects the user to a specific page
     */
    public static function redirect($page) {
        header("Location: " . __URL__ . $page);
    }

    /**
     * @param $page
     *
     * Echos and href link to another page
     */
    public static function href($page) {
        echo __URL__ . $page;
    }
}