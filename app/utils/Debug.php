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

namespace Snail\App\Utils;

use Tracy\BlueScreen;
use Tracy\Debugger;

use Snail\App\Exception\SnailException;

class Debug {
    /**
     * @param $data
     * dumps data with the Tracy debugger
     */
    public static function dump($data) {
        echo "<code style='color: #1b6d85'>";
        \Tracy\Debugger::dump($data);
        echo "</code>";
    }

    /**
     * @param $data
     * dumps data with the Tracy debugger
     */
    public static function exitdump($data) {
        echo "<code style='color: #1b6d85'>";
        \Tracy\Debugger::dump($data);
        echo "</code>";

        exit(0);
    }

    /**
     * @param $data
     *
     * Renders a Tracy bluescreen with
     * provided exception/data
     */
    public static function fatal($data) {
        /* Bluescreen object */
        $bluescreen = new BlueScreen();

        /* Render the bluescreen */
        $bluescreen->render(new SnailException($data));
        exit(0);
    }
}
