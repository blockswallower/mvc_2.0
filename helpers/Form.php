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
    public static function open($method, $action) {
        /**
         * Instantiates a new form.
         * parameters will fill in the
         * required
         */
        echo "<form method='".$method."' action='".$action."' role='form'>";
    }

    public static function close() {
        /**
         * Closes the form
         */
        echo '</form>';
    }

    /**
     * @param $name
     */
    public static function submit($name) {
        /**
         * Generates a submit button
         */
        echo '<input type="submit" value="submit" name="'.$name.'"/>';
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
    public static function text($name, $placeholder) {
        /**
         * Generates text input field
         */
        echo '<input type="text" name="'.$name.'" placeholder="'.$placeholder.'"/>';
    }
}