<?php

class XSS {
    /**
     * This class will mainly be used
     * to prevent Xross site scripting
     */

    /**
     * @param $data
     * @return string
     * @return array
     *
     * Returns string|array secured
     * against cross site scripting
     */
    public static function xss_prevent($data) {
        if (!is_array($data)) {
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

        $ret = array();

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $ret[$key] = self::xss_prevent($data[$key]);
                continue;
            }

            $ret[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $ret;
    }

    /**
     * @param $data
     * @return string
     *
     * Echos string secured
     * against cross site scripting
     */
    public static function xss_echo($data) {
        echo self::xss_prevent($data);
    }

    /**
     * @param $data
     * @return string
     *
     * Cleans string for javascript/vb
     * encodings
     */
    public static function xss_clean($data) {
        /**
         * Fix &entity\n;
         */
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        /**
         * Remove any attribute starting with "on" or xmlns
         */
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        /**
         * Remove javascript: and vbscript: protocols
         */
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        /**
         * Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
         */
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        /**
         * Remove namespaced elements (we do not need them)
         */
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        $old_data = $data;
        while ($old_data !== $data) {
            /**
             * Remove really unwanted tags
             */
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }

        return $data;
    }
}