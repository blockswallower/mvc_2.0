<?php

use Snail\App\Controller;

class IndexController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function show() {
        $this->view->show('index');
    }
}