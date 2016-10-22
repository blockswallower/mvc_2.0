<?php

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
                Debug::exitdump("post request->" . $key . " is empty");
            }
        } else {
            Debug::exitdump("post request->" . $key . " has not been set");
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
                Debug::exitdump("get request->" . $key . " is empty");
            }
        } else {
            Debug::exitdump("get request->" . $key . " has not been set");
        }

        return null;
    }
}