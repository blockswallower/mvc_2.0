<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

/**
 * store every directory
 * you want to autoload in
 * this array (Can only be PHP files)
 */
$directories = array(
    './helpers',
    './app',
    './lib/ScriptEngine',
    './lib/PHPMailer'
);

/**
 * @param $directory
 *
 * autoloads every directory
 * in the $directories array
 */
function autoload($directories) {
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            exit($dir.' is not a directory!');
        }

        foreach (scandir($dir) as $file) {
            if ($file === '.') {
                continue;
            }

            if ($file === '..') {
                continue;
            }

            if ($file === '.htaccess') {
                continue;
            }

            require $dir. '/' .$file;
        }
    }
}

/**
 * autoloads every directory
 * in the $directories array
 */
autoload($directories);

/**
 * stores the settings object
 */
$settings = new Config();

/**
 * loads in every script given
 * in the settings array/string
 */
$script = new ScriptLoader();

/**
 * stores the Application object
 * and starts the MVC system
 */
$router = new Router();

