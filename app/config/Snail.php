<?php

/**
 * =================================================================
 * @package Snail
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2017 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers/Snail
 * @license Open Source MIT license
 * =================================================================
 */

namespace Snail\App\Config;

final class SNAIL {
    /**
     * @const URL string
     *
     * Contains the full URl
     * where the Snail application is running on, and will
     * be different depending on your host
     */
    const URL = 'http://localhost/refactor/';

    /**
     * @const DB_TYPE string
     *
     * Contains the database driver name
     * PDO is going to connect with
     */
    const DB_TYPE = 'mysql';

    /**
     * @const DB_HOST string
     *
     * Contains the database host, this will depend
     * on the hosting service
     */
    const DB_HOST = 'localhost';

    /**
     * @const DB_NAME string
     *
     * Contains the database name
     */
    const DB_NAME = '';

    /**
     * @const DB_USERNAME string
     *
     * Contains the database username
     */
    const DB_USERNAME = 'root';

    /**
     * @const DB_PASSWORD string
     *
     * Contains the database password
     */
    const DB_PASSWORD = '';

    /**
     * @const APP_NAME string
     *
     * Current application name of Snail
     */
    const APP_NAME = "Snail - PHP framework";

    /**
     * @const APP_VERSION int
     *
     * Snail version
     */
    const APP_VERSION = 0.8;

    /**
     * @const DEFAULT_LANG string
     *
     * Default language set to english
     */
    const DEFAULT_LANG = "en";

    /**
     * @const APP_MAIL string
     *
     * Snail email
     */
    const APP_MAIL = "info@snailframework.com";

    /**
     * @const DEBUG boolean
     *
     * Debug mode
     */
    const DEBUG = true;

    /**
     * @const CSRF boolean
     *
     * If this constant is true, a Csrf token
     * needs to be provided in every form
     */
    const CSRF = true;

    /**
     * @const HEADER string
     *
     * Header file
     */
    const HEADER = './views/layout/header.php';

    /**
     * @const FOOTER string
     *
     * Footer file
     */
    const FOOTER = './views/layout/footer.php';
}