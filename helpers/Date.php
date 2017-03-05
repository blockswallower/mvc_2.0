<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Date {
    /**
     * @return string
     *
     * returns the current date and time
     * example: 2016-11-04 23:02
     */
    public static function now() {
        $date = new DateTime();
        return $date->format("Y-m-d H:i");
    }

    /**
     * @return string
     *
     * returns current year as String
     * example: 2016
     */
    public static function year() {
        $date = new DateTime();
        return $date->format("Y");
    }

    /**
     * @return string
     *
     * returns month number as String
     * example: 11
     */
    public static function month() {
        $date = new DateTime();
        return $date->format("m");
    }

    /**
     * @return string
     *
     * returns day as String
     * example: 04
     */
    public static function day() {
        $date = new DateTime();
        return $date->format("d");
    }

    /**
     * @return string
     *
     * returns current hour as String
     * example: 22
     */
    public static function hour() {
        $date = new DateTime();
        return $date->format("H");
    }

    /**
     * @return string
     *
     * returns simple timestamp as String
     * example: 22:55
     */
    public static function time() {
        $date = new DateTime();
        return $date->format("H:i");
    }
}