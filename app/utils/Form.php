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

class Form {
    /**
     * @var String
     */
    private static $standard_method = 'post';

    /**
     * @param $method
     * @param $action
     * @param $css
     */
    public static function open($method = "", $action = "", $css = "") {
        /* Instantiates a new form */
        if ($method != "") {
            echo "<form method='" . $method  . "' class='" . $css . "' action='" . $action . "' role='form'>\n";
        } else {
            echo "<form method='" . self::$standard_method  . "' class='" . $css . "' action='" . $action . "' role='form'>\n";
        }
    }

    /**
     * Closes the form
     */
    public static function close() {
        /* Closes the form */
        echo '</form>';
    }

    /**
     * @param $name
     * @param $css
     */
    public static function submit($name = "", $css = "") {
        /* Generates a submit button */
        echo '<input type="submit" class="' . $css . '" value="submit" name="' . $name . '"/>' . "\n";
    }

    /**
     * @param $value
     * @param $name
     */
    public static function hidden($value, $name = "") {
        /* Generates hidden input field */
        echo '<input type="hidden" value="' . $value . '" name="' . $name . '"/>' . "\n";
    }

    /**
     * @param $name
     * @param $placeholder
     * @param $css
     */
    public static function text($name = "", $placeholder = "", $css = "") {
        /* Generates text input field */
        echo '<input type="text" name="' . $name . '" class="' . $css . '" placeholder="' . $placeholder . '"/>' . "\n";
    }

    /**
     * @param string $onclick
     * @param string $name
     * @param string $value
     * @param string $css
     */
    public static function button($value = "", $onclick = "", $name = "", $css = "") {
        /* Generates simple button */
        echo '<button onclick="' . $onclick . '" class="' . $css . '" name="' . $name . '">' . $value . '</button>';
    }


    /**
     * @return bool
     *
     * Use with request_is_post() to block posting from off-site forms
     */
    public static function request_is_same_domain() {
		if(!isset($_SERVER['HTTP_REFERER'])) {
			/* No refererer sent, so can't be same domain */
			return false;
		} else {
			$referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			$server_host = $_SERVER['HTTP_HOST'];

            if (SNAIL::DEBUG) {
                echo 'Request from: ' . $referer_host . "<br />";
                echo 'Request to: ' . $server_host . "<br />";
            }
			
			return ($referer_host == $server_host) ? true : false;
		}
	}
}