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

use Tracy\Debugger;

class TracySettings {
    public static function init() {
        /* Hides/Shows the Tracy debugger bar */
        Debugger::$showBar = false;

        /* Set strict mode to true/false */
        Debugger::$strictMode = false;
    }
}