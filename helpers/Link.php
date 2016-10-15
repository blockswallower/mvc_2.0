<?php

class Link {
    /**
     * This class will mainly be used
     * to build links with static methods
     */

     /**
      * @var String
      */
     private static $absolute_style_path = __URL__ . 'assets/css/';

     /**
      * @var String
      */
     private static $absolute_script_path = __URL__ . '/assets/js/';

    /**
     * @var String
     */
     private static $absolute_img_path = __URL__ . '/assets/img/';



    /**
     * @param $css_file
     *
     * Generates a stylesheet link
     */
     public static function style($css_file) {
          echo '<link href="' . self::$absolute_style_path.$css_file . '" rel="stylesheet">' . "\n";
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
        echo '<link href="' . $font . '" rel="stylesheet">'."\n";
    }

    /**
     * @param $src
     * @param $width
     * @param $height
     *
     * generates img tag
     */
    public static function img($src, $width, $height, $css = null) {
        /*
         * @var String
         */
        $src = self::$absolute_img_path . $src;

        echo '<img src="' . $src . '" class="' . empty($css) ? "" : $css . '"
               width="' . $width . '" height="' . $height.'">' . "\t";
    }
}