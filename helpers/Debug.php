<?php

class Dedug {
    /**
     * This class will be used for several
     * debug methods
     */

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
}
