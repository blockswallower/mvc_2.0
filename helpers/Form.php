<?php

class Form {
    /**
     * This class will mainly be used
     * to build forms with static methods
     */

    /**
     * @var String
     */
    private static $standard_method = 'post';

    /**
     * @param $method
     * @param $action
     */
    public static function open($method, $action, $css) {
        /**
         * Instantiates a new form.
         * parameters will fill in the
         * required
         */
        echo "<form method='".$method." class=".$css."' action='".$action."' role='form'>";
    }

    /*
     * Closes the form
     */
    public static function close() {
        /**
         * Closes the form
         */
        echo '</form>';
    }

    /**
     * @param $name
     */
    public static function submit($name, $css) {
        /**
         * Generates a submit button
         */
        echo '<input type="submit" class="'.$css.'" value="submit" name="'.$name.'"/>';
    }

    /**
     * @param $value
     * @param $name
     */
    public static function hidden($name, $value) {
        /**
         * Generates hidden input field
         */
        echo '<input type="hidden" value="'.$value.'" name="'.$name.'"/>';
    }

    /**
     * @param $name
     * @param $placeholder
     */
    public static function text($name, $placeholder, $css) {
        /**
         * Generates text input field
         */
        echo '<input type="text" name="'.$name.'" class="'.$css.'" placeholder="'.$placeholder.'"/>';
    }


    /**
     * @return bool
     *
     * Use with request_is_post() to block posting from off-site forms
     */
    public static function request_is_same_domain() {
		if(!isset($_SERVER['HTTP_REFERER'])) {
			/*
			 * No refererer sent, so can't be same domain
			 */
			return false;
		} else {
			$referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			$server_host = $_SERVER['HTTP_HOST'];

            if (Config::get("DEBUG")) {
                echo 'Request from: ' . $referer_host . "<br />";
                echo 'Request to: ' . $server_host . "<br />";
            }
			
			return ($referer_host == $server_host) ? true : false;
		}
	}
}