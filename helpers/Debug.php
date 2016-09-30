<?php

class Debug {
    /**
     * This class will be used for several
     * debug methods
     */

    /**
     * @var String
     */
    public static $standard_error_session = "Error";

    /**
     * @param $data
     *
     * dumps data between
     * <pre> tags
     */
    public static function dump($data) {
        echo '<pre>';
            var_dump($data);
        echo '</pre>';
    }

    /**
     * @param $data
     *
     * dumps data between
     * <pre> tags and ends
     * the programme
     */
    public static function exitdump($data) {
        echo '<pre>';
            var_dump($data);
        echo '</pre>';
        
        exit;
    }

    /**
     * @param $data
     * @param $line
     *
     * dumps data between
     * <pre> tags on a different page 
     * and ends the programme
     *
     * If you want the linenumber from where
     * this dump is executed to appear,
     * use this method as follows:
     *
     * Debug::pagedump("This is a dump!", __LINE__);
     */
    public static function pagedump($data, $linenumber = null) {
        if (Settings::$config['DEBUG']) {
            /*
             * @var String
             */
            $cur_controller = ucfirst(Controller::return_current_controller())."Controller";

            if ($linenumber != null) {
                /*
                * @var String
                */
                $debug_info = "Page dump call: line ". $linenumber ."<br>Controller/Class: ". $cur_controller;
            } else {
                /*
                * @var String
                */
                $debug_info = "Controller/Class: ". $cur_controller;
            }


            Sessions::set("debug_info", $debug_info);
            Sessions::set(self::$standard_error_session, $data);
            Redirect::to("debug");
        }
    }
}
