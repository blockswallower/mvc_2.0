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

            require $dir. '/' .$file;
        }
    }
}


/**
 * loads in every scripts given
 * in the settings array
 */
function load_scripts() {
    if (Settings::$config['SCRIPT']['EVERY_TIME_EXECUTION'] != 'NONE') {
        $scripts = Settings::$config['SCRIPT']['EVERY_TIME_EXECUTION'];
        $dir = './scripts';

        if (is_array($scripts)) {
            foreach($scripts as $script) {
                if ($script != "NONE")
                    require $dir. '/' .$script;
            }
        } else {
            if ($scripts != "NONE")
                require $dir. '/' .$scripts;
        }
    }

    if (Settings::$config['SCRIPT']['ONE_TIME_EXECUTION'] != 'NONE') {
        $settingsContent = './app/Settings.php';
        $scripts = Settings::$config['SCRIPT']['ONE_TIME_EXECUTION'];
        $dir = './scripts';

        if (is_array($scripts)) {
            foreach($scripts as $script) {
                if ($script != "NONE")
                    require $dir. '/' .$script;
            }
        } else {
            if ($scripts != "NONE")
                require $dir. '/' .$scripts;
        }

        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $newSettingsContent = str_replace($scripts, 'NONE', file_get_contents($settingsContent));
                file_put_contents($settingsContent, $newSettingsContent);
            }
        } else {
            $newSettingsContent = str_replace($scripts, 'NONE', file_get_contents($settingsContent));
            file_put_contents($settingsContent, $newSettingsContent);
        }
    }
}

/**
 * autoloads every directory
 * in the $directories array
 */
autoload($directories);

/**
 * @var object
 *
 * stores the settings object
 */
$settings = new Settings();

/**
 * loads in every scripts given
 * in the settings array
 */
load_scripts();

/**
 * @var object
 *
 * stores the Application object
 * and starts the MVC system
 */
$app = new Application();

