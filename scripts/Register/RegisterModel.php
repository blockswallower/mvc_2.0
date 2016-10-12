<?php

class RegisterModel extends Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function register() {
		if (validate_request()) {
			$hash = md5(rand(0,1000).time());
			$result = $this->user_check();
			
			if ($result) {
				$result = $this->email_sent($hash);
			} else {
				Debug::pagedump('Username and/or email address is already registered');
	            return false;
	        }
	
	        if ($result) {
	            $result = $this->after_successful_check($hash);
	        } else {
	            Debug::pagedump('Verify email has not been send, please try again');
	            return false;
	        }
	
	        if ($result) {
	            Debug::pagedump('You are successfully registered, <br /> please verify youre email address by clicking the activation link that  to your email address');
	            return true;
	        } else {
	            Debug::pagedump('Something went wrong, please try again');
	            return false;
	        }
        }
    }

    private function user_check() {
        $username = htmlspecialchars($_POST['username']);
        $email = $_POST['email'];
        $result = $this->db->prepare('SELECT * FROM users WHERE username = :username OR email = :email;');
        $result->execute(array(
            ':username' => $username,
            ':email' => $email
        ));

        $count = $result->rowCount();
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function after_successful_check($hash) {
        $username = htmlspecialchars($_POST['username']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = $this->db->prepare('INSERT INTO users (username, password, email, hash, active) VALUES (:username, :password, :email, :hash, :active);');
        $insert = $result->execute(array(
            ':username' => $username,
            ':password' => $password,
            ':email' => $email,
            ':hash' => $hash,
            ':active' => 0
        ));

        return $insert;
    }

    private function email_sent($hash) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $result = Email::verification_email($email, $username, $password, $hash);
        return $result;
    }
}