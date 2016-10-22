<?php

class RegisterController extends Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load_model('register');

        $this->view->show('register');
    }

    public function register() {
        if (empty(Request::post("username")) || empty(Request::post("email")) || empty(Request::post("email_confirm"))
            || empty(Request::post("password")) || empty(Request::post("password_confirm"))) {

            Debug::pagedump("Please fill in the required fields");
        }

        $password_check = $this->password_check();
        $email_check = $this->email_check();
        $username_check = $this->username_check();

        if ($password_check && $email_check && $username_check) {
            $this->register->register();
        }
    }

    public function password_check() {
        if (Request::post("password") !== $_POST['password_confirm']) {
           Debug::pagedump("Please fill in the required fields");
           return false;
        }

        if (strlen(Request::post("password")) < 5) {
            Debug::pagedump('Password most be longer than 5 characters');
            return false;
        }

        if (strlen(Request::post("password")) > 20) {
            Debug::pagedump('Password most be shorter than 20 characters');
            return false;
        }

        if( !preg_match("#[a-z]+#", Request::post("password")) ) {
            Debug::pagedump('Password must include at least one lowercase letter');
            return false;
        }

        if( !preg_match("#[A-Z]+#", Request::post("password")) ) {
            Debug::pagedump('Password must include at least one uppercase letter');
            return false;
        }

        return true;
    }

    public function email_check() {
        if (Request::post("email") !== $_POST['email_confirm']) {
            Debug::pagedump('Email addresses do not match');
            return false;
        }

        if (filter_var(Request::post("email"), FILTER_VALIDATE_EMAIL) === false) {
            Debug::pagedump('Email addresses is not valid');
            return false;
        }

        return true;
    }

    public function username_check() {
        if (strlen(Request::post("username")) > 20) {
            Debug::pagedump('Username most be shorter than 20 characters');
            return false;
        }

        if (strlen(Request::post("username")) < 5) {
            Debug::pagedump('Username most be longer than 5 characters');
            return false;
        }

        return true;
    }
}