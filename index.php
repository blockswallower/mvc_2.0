<?php

/**
 * @var array
 *
 * store every directory
 * you want to autoload in
 * this array
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

$app = new Application();

