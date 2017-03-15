<?php

class AjaxController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->load_model('index');
    }

    public function get() {
        echo json_encode(["key" => "value"]);
    }

    public function post() {
        var_dump(json_decode($_POST['data']));
    }
}