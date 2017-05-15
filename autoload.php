<?php

/* Autoloader for the Snail application */
spl_autoload_register(function($class) {
    /* This array contains namespaces with their corresponding folder names */
    $namespaces = [
        'Snail\\App\\' => 'app',
        'Snail\\App\\Http' => 'app/http',
        'Snail\\App\\Utils' => 'app/utils',
        'Snail\\App\\Exception' => 'app/utils/exception',
        'Snail\\App\\Config' => 'app/config',
    ];

    $base_path = '';

    foreach ($namespaces as $namespace => $base) {
        if (strncmp($namespace, $class, strlen($namespace)) === 0) {
            $relative_class = substr($class, strlen($namespace));
            $base_path = $base;
        }
    }

    if (empty($base_path)) {
        return;
    }

    $file = $base_path . '/' . str_replace('\\', '/', strtolower($relative_class)) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});