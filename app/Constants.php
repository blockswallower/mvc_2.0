<?php

/**
 * Any constants can be defined in this
 * file.
 *
 * All constants will instantly be included by
 * the autoloader in the index.php file
 */
define("__URL__", "http://localhost/Snail_MVC/");

/**
 * Bool is true if ajax call is made
 */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

