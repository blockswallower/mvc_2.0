<?php

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
}