<?php

/**
 * @var array
 *
 * store every directory
 * you want to autoload in
 * this array (Can only be PHP files)
 */
$directories = array(
    './app',
    './helpers'
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
            if ('.' === $file)
                continue;

            if ('..' === $file)
                continue;

            require $dir.'/'.$file;
        }
    }
}

autoload($directories);


/**
 * @var object
 *
 * stores the settings object
 */
$settings = new Settings();

if (Settings::$config['SCRIPT']['FILES'] != false) {
    $scripts = Settings::$config['SCRIPT']['FILES'];
    $dir = './scripts';

    if (is_array($scripts)) {
        foreach($scripts as $script) {
            require $dir. '/' .$script;
        }
    } else {
        require $dir. '/' .$scripts;
    }

    if (!Settings::$config['SCRIPT']['ONE_TIME_EXECUTION']) {
        // tbd
    }
}

$app = new Application();

