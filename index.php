<?php

namespace Snail;

use Snail\App\Bootstrap;
use Snail\App\Config\TracySettings;
use Tracy\Debugger;

/* Include autoloaders */
require_once 'autoload.php';
require_once 'vendor/autoload.php';

/* Enable the Tracy debugger */
Debugger::enable();

/* Set Tracy configurations */
TracySettings::init();

/* Start Snail! */
$app = new Bootstrap();