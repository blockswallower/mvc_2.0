<?php

class Sessions {
    /**
     * This Sessions class is in control
     * of all sessions
     *
     * NOTE: Editing this file might corrupt
     * the overall functionality
     */

    /**
     * @var boolean
     */
    private static $check_ip = false;

    /**
     * @var boolean
     */
    private static $check_user_agent = false;

    /**
     * @var boolean
     */
    private static $check_last_login = false;

    /**
     * @var integer
     */
    private static $max_elapsed = 86400;

    /**
     * Starts a session
     *
     * 1 day
     */
    public static function init() {
        /*
         * Starts a sessions if no sessions was started
         */
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param $key
     * @param $value
     *
     * Sets a value to a session
     */
    public static function set($key, $value) {
        /**
         * @session $value
         */
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     *
     * Returns a specific value
     */
    public static function get($key) {
        /**
         * @session $key
         */
        return $_SESSION[$key];
    }

    /**
     * @param $key
     * @return mixed
     *
     * forcibly end the session
     */
    public static function end_all_sessions() {
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();
        }
    }

    /**
     * @param $session
     *
     * unset a specific session
     */
    public static function end_session($session) {
        if (!empty($session)) {
            unset($session);
        }
    }

    /**
     * Actions to preform before giving
     * access to any access-restricted page.
     */
    public static function login_confirm() {
        self::confirm_user_logged_in();
        self::confirm_session_is_valid();
    }

    /**
     * If user is not logged in,
     * end and redirect to login page.
     */
    public static function confirm_user_logged_in() {
        if (!self::is_logged_in()) {
            self::end_all_sessions();
            /*
             * Note that header redirection requires output buffering
             * to be turned on or requires nothing has been output
             * (not even whitespace).
             */

            header("Location: index");
            exit;
        }
    }

    /*
     * If session is not valid,
     * end and redirect to login page.
     */
    public static function confirm_session_is_valid() {
        if (!self::is_session_valid()) {
            self::end_all_sessions();
            /*
            * Note that header redirection requires output buffering
            * to be turned on or requires nothing has been output
            * (not even whitespace).
            */

            header("Location: index");
            exit;
        }
    }

    /**
     * @return bool
     *
     * Should the session be considered valid?
     */
    public static function is_session_valid() {
        /**
         * set static variable 'check_ip'
         * to TRUE
         */
        self::$check_ip = true;

        /**
         * set static variable 'check_user_agent'
         * to TRUE
         */
        self::$check_user_agent = true;

        /**
         * set static variable 'check_last_login'
         * to TRUE
         */
        self::$check_last_login = true;

        if (self::$check_ip && !self::request_ip_matches_session()) {
            return false;
        }

        if (self::$check_user_agent && !self::request_user_agent_matches_session()) {
            return false;
        }

        if (self::$check_last_login && !self::last_login_is_recent()) {
            return false;
        }

        return true;
    }


    /**
     * @return bool
     *
     * Does the request IP match the stored value?
     */
    public static function request_ip_matches_session() {
        /**
         * return false if either value is not set
         */
        if (!isset($_SESSION['ip']) || !isset($_SERVER['REMOTE_ADDR'])) {
            return false;
        }

        if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return bool
     *
     * Does the request user agent match the stored value?
     */
    public static function request_user_agent_matches_session() {
        /**
         * return false if either value is not set
         */
        if (!isset($_SESSION['user_agent']) || !isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }

        if ($_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     *
     * Has too much time passed
     * since the last login?
     */
    public static function last_login_is_recent() {
        /**
         * return false if value is not set
         */
        if (!isset($_SESSION['last_login'])) {
            return false;
        }

        if (($_SESSION['last_login'] + self::$max_elapsed) >= time()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return bool
     *
     * Is user logged in already?
     */
    public static function is_logged_in() {
        return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
    }

    /**
     * return false if value is not set
     */
    public static function after_successful_logout() {
        $_SESSION['logged_in'] = false;
        self::end_all_sessions();
    }


    /**
     * Exit the programme if no ajax call was made
     */
    public static function access_ajax_only() {
        if(!IS_AJAX) {
            die('Restricted access');
        }

        $pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));

        if($pos === false) {
            die('Restricted access');
        }

    }
}