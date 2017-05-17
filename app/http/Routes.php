<?php

namespace Snail\App\Http;

use Snail\App\Router;
use Snail\App\View;

$router = new Router();

$router->base(function() {
    return new View('index');
});

$router->get('blabla/{param}', function() use ($router) {
    return new View('blabla', $router->get_param());
});

$router->get('test', function() {
    return new View('test');
});

$router->post('login', function() use ($router) {
    $router->form_action('TestController', 'login');
});