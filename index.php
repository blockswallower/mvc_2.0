<?php

spl_autoload_register(function($class){
    require 'app/'.$class.'.php';
});

$app = new Application();