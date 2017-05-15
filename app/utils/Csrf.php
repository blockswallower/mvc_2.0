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

use Snail\App\Utils\Debug;

class Csrf {
    /**
     * Must call session_start() before this loads
     */

    /**
     * Generate a token for use with CSRF protection.
     * Does not store the token.
     */
    public static function csrf_token() {
        return md5(uniqid(rand(), true));
    }

    /**
     * Generate and store CSRF token in user session.
     * Requires session to have been started already.
     */
    public static function create_csrf_token() {
        $token = self::csrf_token();

        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();

        return $token;
    }

    /*
     * Sets the csrf session with the same value as
     * $_POST['csrf_token']
     */
    public static function set_csrf_session() {
        if (!empty($_POST['csrf_token'])) {
            $_SESSION['csrf_token'] = $_POST['csrf_token'];
        }
    }

    /**
     * Destroys a token by removing it from the session.
     */
    public static function destroy_csrf_token() {
        $_SESSION['csrf_token'] = null;
        $_SESSION['csrf_token_time'] = null;

        return true;
    }

    /**
     * Return an HTML tag including the CSRF token
     * for use in a form.
     * Usage: echo csrf_token_tag();
     */
    public static function csrf_token_tag() {
        $token = self::create_csrf_token();

        return "<input type=\"hidden\" name=\"csrf_token\" value=\"" . $token . "\">";
    }

    /**
     * Returns true if user-submitted POST token is
     * identical to the previously stored SESSION token.
     * Returns false otherwise.
     */
    public static function csrf_token_is_valid() {
        if (isset($_POST['csrf_token'])) {
            $user_token = $_POST['csrf_token'];
            $stored_token = $_SESSION['csrf_token'];

            return $user_token === $stored_token;
        } else {
            Debug::dump("POST CSRF token is not identical to stored SESSION");
        }
    }

    /**
     * You can simply check the token validity and
     * handle the failure yourself, or you can use
     * this "stop-everything-on-failure" function.
     */
    public static function die_on_csrf_token_failure() {
        if (!self::csrf_token_is_valid()) {
            Debug::dump("CSRF token validation failed");
        }
    }

    /**
     * Optional check to see if token is also recent
     */
    public static function csrf_token_is_recent() {
        $max_elapsed = 60 * 60 * 24;

        if (isset($_SESSION['csrf_token_time'])) {
            $stored_time = $_SESSION['csrf_token_time'];

            return ($stored_time + $max_elapsed) >= time();
        } else {
            /**
             * Remove expired token
             */
            self::destroy_csrf_token();
            Debug::dump("CSRF Token is not recent!");
        }
    }

    /**
     * GET requests should not make changes
     * Only POST requests should make changes
     */
    public static function request_is_get() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * POST requests should not make changes
     * Only GET requests should make changes
     */
    public static function request_is_post() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Validates request
     */
    public static function validate_request() {
        if (self::request_is_post()) {
            if (self::csrf_token_is_valid()) {
                if (self::csrf_token_is_recent()) {
                    return true;
                } else {
                    Debug::dump("CSRF Token is not recent!");
                }
            } else {
                Debug::dump("CSRF Token is not valid!");
            }
        } else {
            /* form not submitted or was GET request */
            Debug::dump("Form not submitted or was GET request");
        }
    }
}
