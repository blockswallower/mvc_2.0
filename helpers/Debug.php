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
}
