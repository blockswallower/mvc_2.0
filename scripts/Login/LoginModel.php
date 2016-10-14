<?php

class LoginModel extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $this->db->prepare('SELECT * FROM users WHERE username = :username AND password = :password;');
        $result->execute(array(
            ':username' => $username,
            ':password' => $password
        ));

        $count = $result->rowCount();

        if ($count > 0) {
            $this->after_successful_login();
            $_SESSION['username'] = $username;

            Redirect::to("index");
        } else {
            Debug::pagedump("Login failed");
            return false;
        }
    }

    private function after_successful_login() {
        session_regenerate_id();

        Sessions::set("logged_in", true);
        Sessions::set("ip", $_SERVER['REMOTE_ADDR']);
        Sessions::set("user_agent", $_SERVER['HTTP_USER_AGENT']);
        Sessions::set("last_login", time());
    }
}