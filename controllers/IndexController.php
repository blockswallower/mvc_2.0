<?php

class IndexController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->config_view_array();
        $this->view->show('index');
    }
}