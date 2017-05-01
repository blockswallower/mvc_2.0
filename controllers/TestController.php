<?php

use Snail\App\Controller;
use Snail\App\Utils\Debug;

class TestController extends Controller {
    public function __construct() {
        /* Load the test model */
        $this->load_model('test');

        parent::__construct();
    }

    public function show() {
        $this->view->show("test");
    }
}