<?php

class Link {
    /**
     * This class will mainly be used
     * to build links with static methods
     */

     /**
      * @var String
      */
     private static $absolute_style_path = 'http://localhost/mvc_2.0/assets/css/';

     /**
      * @var String
      */
     private static $absolute_script_path = 'http://localhost/mvc_2.0/assets/js/';

    /**
     * @var String
     */
     private static $absolute_img_path = 'http://localhost/mvc_2.0/assets/img/';



    /**
     * @param $css_file
     */
     public static function style($css_file) {
          /**
           * Generates a stylesheet link
           */
          echo '<link href="'.self::$absolute_style_path.$css_file.'" rel="stylesheet">'."\n";
     }

    /**
     * @param $js_file
     */
     public static function script($js_file) {
          /**
           * Generates a javascript
           * file link
           */
          echo '<script src="'.self::$absolute_script_path.$js_file.'"></script>'."\n";
     }

    /**
     * @param $font
     */
    public static function google_font($font) {
        /**
         * Generates a google font style tag
         */
        echo '<link href="'.$font.'" rel="stylesheet">'."\n";
    }

    /**
     * @param $src
     * @param $width
     * @param $height
     *
     * generates img tag
     */
    public static function img($src, $width, $height) {
        $src = self::$absolute_img_path.$src;
        echo '<img src="'.$src.'" width="'.$width.'" height="'.$height.'">'."\t";
    }
}