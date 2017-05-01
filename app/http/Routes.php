<?php

namespace Snail\App\Http;

use Snail\App\Router;
use Snail\App\View;

$router = new Router();

/*
 * the 'base' method configures the default
 * route. In this case we create a new view
 * linked to the IndexController
 */
$router->base(function() {
    return new View('index');
});

$router->get('blabla/{param}', function() {
    return new View('blabla', Router::get_param());
});

$router->get('test', function() {
    return new View('test');
});

$router->post('login', function() {
    Router::form_action('TestController', 'login');
});