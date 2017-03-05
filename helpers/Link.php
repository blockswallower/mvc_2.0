<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class Link {
    /**
     * This class will mainly be used
     * to build links with static methods
     */

     /**
      * Style path
      */
     private static $absolute_style_path = __URL__ . 'assets/css/';

     /**
      * Scripts path
      */
     private static $absolute_script_path = __URL__ . '/assets/js/';

    /**
     * img path
     */
     private static $absolute_img_path = __URL__ . '/assets/img/';



    /**
     * @param $css_file
     *
     * Generates a stylesheet link
     */
     public static function style($css_file) {
          echo '<link href="' . self::$absolute_style_path . $css_file . '" rel="stylesheet">' . "\n";
     }

    /**
     * @param $js_file
     *
     * Generates a javascript
     * file link
     */
     public static function script($js_file) {
          echo '<script src="' . self::$absolute_script_path . $js_file . '"></script>' . "\n";
     }

    /**
     * @param $font
     *
     * Generates a google font style tag
     */
    public static function google_font($font) {
        echo '<link href="' . $font . '" rel="stylesheet">' . "\n";
    }

    /**
     * @param $src
     * @param $width
     * @param $height
     *
     * generates img tag
     */
    public static function img($src, $width, $height, $css = null) {
        $src = self::$absolute_img_path . $src;

        echo '<img src="' . $src . '" class="' . empty($css) ? "" : $css . '"
               width="' . $width . '" height="' . $height.'">' . "\t";
    }

    /**
     * @param $search_term
     * @param $between_tags
     *
     * Googles the given search term
     */
    public static function google($search_term, $between_tags) {
        $split = explode(" ", $search_term);
        $search_term = "https://www.google.nl/#q=";
        $last_index = Arr::find_index($split, Arr::last($split));

        for ($ii = 0; $ii < Arr::size($split); $ii++) {
            $search_term .= $split[$ii];
            $search_term .= $last_index != $ii ? "+" : "";
        }

        echo '<a href="' . $search_term . '">' . $between_tags . '</a>';
    }
}