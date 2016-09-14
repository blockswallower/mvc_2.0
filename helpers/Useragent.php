<?php

class Useragent {
    /*
     * This class will mainly be used
     * for handling user agent related
     * actions
     */

    /**
     * @return string
     *
     * Returns browser currently in use:
     *
     * Opera / OPR = "Opera"
     * Google Chrome = "Chrome"
     * Microsoft Edge = "Edge"
     * Safari = "Safari"
     * Firefox = "Firefox"
     * Internet explorer / Trident7 = "Internet Explorer"
     *
     */
    public static function get_browser() {
        /*
         * @var String
         */
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {
            return 'Opera';
        } else if (strpos($user_agent, 'Edge')) {
            return 'Edge';
        } elseif (strpos($user_agent, 'Chrome')) {
            return 'Chrome';
        } elseif (strpos($user_agent, 'Safari')) {
            return 'Safari';
        } elseif (strpos($user_agent, 'Firefox')) {
            return 'Firefox';
        } elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) {
            return 'Internet Explorer';
        }

        return 'Other';
    }

    /**
     * @return mixed|string
     *
     * Returns Operating System
     */
    public static function get_OS() {
        /*
         * @var String
         */
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        /*
         * @var String
         */
        $os_platform = "Unknown OS Platform";

        /*
         * @var Array
         */
        $os_array = array (
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    /**
     * @return mixed
     *
     * Returns full User agent string
     */
    public static function get_full_user_agent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}