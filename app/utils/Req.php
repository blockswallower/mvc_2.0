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

class Req {
    /**
     * @param $key
     * @return null
     *
     * Returns post variable based
     * on given parameter
     *
     */
    public static function post($key) {
        if (isset($_POST[$key])) {
            if (!empty($_POST[$key])) {
                return $_POST[$key];
            } else {
                Debug::dump("post request->" . $key . " is empty");
            }
        } else {
            Debug::dump("post request->" . $key . " has not been set");
        }

        return null;
    }

    /**
     * @param $key
     * @return null
     *
     * Returns get variable based
     * on given parameter
     */
    public static function get($key) {
        if (isset($_GET[$key])) {
            if (!empty($_GET[$key])) {
                return $_GET[$key];
            } else {
                Debug::dump("get request->" . $key . " is empty");
            }
        } else {
            Debug::dump("get request->" . $key . " has not been set");
        }

        return null;
    }
}