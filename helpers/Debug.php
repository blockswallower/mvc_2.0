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
     * @param $linenumber
     * @param $coreSnailClass
     *
     * dumps data between
     * <pre> tags on a different page 
     * and ends the programme
     *
     * If you want the linenumber from where
     * this dump is executed to appear,
     * use the Magic constants build in PHP as the second argument:
     *
     * Debug::pagedump("This is a dump!", __LINE__);
     *
     * If you are using a core snail functionality class and
     * you don't want to dump the current controller, just fill
     * in the file (as String) where you execute the dump as a third argument.
     *
     * Debug::pagedump("This is a dump!", __LINE__, [NAME OF FILE]);
     *
     * or use the PHP magic constant:
     *
     * Debug::pagedump("This is a dump!", __LINE__, __CLASS__);
     */
    public static function pagedump($data, $linenumber = null, $coreSnailClass = null) {
        if (Config::get('DEBUG')) {
            /*
             * @var String
             */
            $cur_controller = ucfirst(Controller::return_current_controller())."Controller";

            /*
             * @var String
             */
            $debug_info = "";

            if ($linenumber != null && $coreSnailClass == null) {
                $debug_info = "Page dump call: line ". $linenumber ."<br>Controller/Class: ". $cur_controller;
            } else if ($linenumber == null && $coreSnailClass == null) {
                $debug_info = "Controller/Class: ". $cur_controller;
            }

            if ($linenumber != null && $coreSnailClass != null) {
                $debug_info = "Page dump call: line ". $linenumber ."<br>Controller/Class: ". $coreSnailClass. ".php";
            } else if ($linenumber == null && $coreSnailClass != null) {
                $debug_info = "Controller/Class: ". $coreSnailClass . ".php";
            }


            Sessions::set("debug_info", $debug_info);
            Sessions::set(self::$standard_error_session, $data);
            Url::redirect("debug");
        }
    }
}
