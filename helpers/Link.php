<?php

class Link {
    /**
     * This class will mainly be used
     * to build links with static methods
     */

     /**
      * @var String
      */
     private static $absolute_style_path = __URL__.'assets/css/';

     /**
      * @var String
      */
     private static $absolute_script_path = __URL__.'assets/js/';


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
}