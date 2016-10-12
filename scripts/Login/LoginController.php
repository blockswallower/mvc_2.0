<?php

class LoginController extends Controller {
    public function __construct(){
        parent::__construct();

        $this->loadmodel("login");

        $this->view->show("login");
    }

    public function login() {
	    if (validate_request()) {
	        if (empty($_POST["username"]) || empty($_POST["password"])) {
	            Debug::pagedump("Please fill in the required fields");
	            return false;
	        }
	
	        $this->login->login();
	    }
    }
}
    