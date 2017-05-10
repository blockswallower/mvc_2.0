<?php

namespace Snail\App\Http;

use Snail\App\Router;
use Snail\App\View;

$router = new Router();

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