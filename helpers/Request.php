<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Request {
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
                Debug::exitdump("post request->" . $key . " is empty", __LINE__, "helpers/Request");
            }
        } else {
            Debug::exitdump("post request->" . $key . " has not been set", __LINE__, "helpers/Request");
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
                Debug::exitdump("get request->" . $key . " is empty", __LINE__, "helpers/Request");
            }
        } else {
            Debug::exitdump("get request->" . $key . " has not been set", __LINE__, "helpers/Request");
        }

        return null;
    }
}