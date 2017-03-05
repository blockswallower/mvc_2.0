<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Debug {
    /**
     * This class will be used for several
     * debug methods
     */

    /*
     * @var String
     */
    private static $standard_path = "./";

    /**
     * @param $data
     *
     * dumps data between
     * <pre> tags
     */
    public static function dump($data) {
        echo '<code style="color: #1b6d85">';
            print_r($data);
        echo '</code>';
    }

    /**
     * @param $data
     * @param $linenumber
     * @param $coreSnailClass
     *
     * dumps data between
     * <pre> tags and ends
     * the programme
     *
     * if you want the linenumber from where
     * this dump is executed to appear,
     * use the Magic constants build in PHP as the second argument:
     *
     * Debug::exitdump("This is a dump!", __LINE__);
     *
     * If you are using a core snail functionality class and
     * you don't want to dump the current controller, just fill
     * in the file (as String) where you execute the dump as a third argument.
     *
     * Debug::exitdump("This is a dump!", __LINE__, [NAME OF FILE]);
     *
     * or use the PHP magic constant:
     *
     * Debug::exitdump("This is a dump!", __LINE__, __CLASS__);
     */
    public static function exitdump($data, $linenumber = null, $coreSnailClass = null) {
        if (Config::get("DEBUG")) {
            $cur_controller = ucfirst(Controller::return_current_controller())."Controller";

            /**
             * Blanks out the page using javascript
             */
            echo("
                <script type='text/javascript'>
                    document.body.innerHTML = '';
                </script>\n
            ");

            echo "<div style='width: 100%;
                        background-color: lightgoldenrodyellow;
                        margin-top: -10px;
                        margin-left: -10px;
                        padding-left: 30px;
                        padding-top: 10px;
                        padding-bottom: 30px;'>\n";

            echo "<h1 style='color: #1b6d85'>Something went wrong!</h1>\n";

            /**
             * Debug::dump the dump value
             */
            echo "Debug value: <br>\n";

            /**
             * If $data is an array Debug::dump it,
             * if not just print the value
             */
            if (is_array($data)) {
                Debug::dump($data);
                echo "<br><br>";
            } else {
                echo "<h3 style='color: #1b6d85'>$data</h3>\n";
            }

            /**
             * Print the Server Request Method
             */
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "Request method: Post<br>\n";
            } else {
                echo "Request method: Get<br>\n";
            }

            $url = '';

            foreach(Router::get_url() as $route) {
                $url .= $route . "/";
            }

            /**
             * Print the Request URL
             */
            echo "Request URL: " . $url . "<br>\n";

            /**
             * Print the Snail Version
             */
            echo "Snail version: " . Config::get("APP_VERSION") . "<br>\n";

            /**
             * Print the file where the exitdump was executed
             */
            if ($coreSnailClass !== null) {
                echo "Given class: " . $coreSnailClass . "<br>\n";
            } else {
                echo "View rendered from: " . $cur_controller . "<br>\n";
            }

            /**
             * Print the line number
             */
            if ($linenumber !== null) {
                echo "Execution line: " . $linenumber . "<br>\n";
            }

            /**
             * Print actual date and time of execution
             */
            echo "Server time: " . Date::now() . "<br>\n";

            if ($linenumber !== null) {
                $filename = $coreSnailClass !== null ? $coreSnailClass : "controllers/" . $cur_controller;
                $lines = file(self::$standard_path . $filename . ".php");

                for ($ii = 0; $ii < Arr::size($lines); $ii++) {
                    if ($ii + 1 == $linenumber) {
                        echo "Code: <code>$linenumber " . htmlentities($lines[$ii]) . "</code>";
                    }
                }
            }

            echo "</div>";

            exit;
        }
    }
}
