<?php

class Redirect {
    /**
     * This class will mainly be used
     * to make redirecting easy
     */

    /**
     * Redirect the user to
     * the previous page
     */
    public static function back() {
        /**
         * @var string
         */
        $previous_page = 'javascript://history.go(-1)';

        header("location:" . $previous_page);
    }

    /**
     * @param $page
     *
     * Redirects the user to a specific page
     */
    public static function to($page) {
        header("Location: " . __URL__ . $page);
    }
}