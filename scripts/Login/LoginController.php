<?php

class LoginController extends Controller {
    public function __construct(){
        parent::__construct();

        $this->load_model("login");

        $this->view->show("login");
    }

    public function login() {
	    if (Csrf::validate_request()) {
	        if (empty(Request::post("username")) || empty(Request::post("password"))) {
	            Debug::pagedump("Please fill in the required fields");
	            return false;
	        }
	
	        $this->login->login();
	    }
    }
}
    