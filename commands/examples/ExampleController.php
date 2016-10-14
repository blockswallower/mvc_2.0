<?php

class ExampleController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function show() {
        $this->view->show("example");
    }
}