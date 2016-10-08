<?php

if (!file_exists('controller/LoginController.php')) {
    $controller = fopen('./controllers/LoginController.php', 'w');

    fwrite($controller,
'<?php

class LoginController extends Controller {
    public function __construct(){
        parent::__construct();

        $this->loadmodel("login");

        $this->config_globals_array();

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
    ');
}

if (!file_exists('models/LoginModel.php')) {
    $model = fopen('./models/LoginModel.php', 'w');

    fwrite($model,
'<?php

class LoginModel extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function login() {
        $username = $_POST[\'username\'];
        $password = $_POST[\'password\'];

        $result = $this->db->prepare(\'SELECT * FROM users WHERE username = :username AND password = :password;\');
        $result->execute(array(
            \':username\' => $username,
            \':password\' => $password
        ));

        $count = $result->rowCount();

        if ($count > 0) {
            $this->after_successful_login();
            $_SESSION[\'username\'] = $username;

            Redirect::to("index");
        } else {
            Debug::pagedump("Login failed");
            return false;
        }
    }

    private function after_successful_login() {
        session_regenerate_id();
        $_SESSION[\'logged_in\'] = true;
        $_SESSION[\'ip\'] = $_SERVER[\'REMOTE_ADDR\'];
        $_SESSION[\'user_agent\'] = $_SERVER[\'HTTP_USER_AGENT\'];
        $_SESSION[\'last_login\'] = time();
    }
}
    ');
}

if (!file_exists('views/login.php')) {
    $view = fopen('./views/login.php', 'w');

    fwrite($view,
"<h1>Login</h1>
<form class=\"login-form\" method=\"post\" action=\"<?php echo __URL__; ?>login/login\">
    <input type=\"text\" class=\"username\" name=\"username\" placeholder=\"username\">
    <input  type=\"password\" class=\"password\" name=\"password\" placeholder=\"Password\">
    <?php echo csrf_token_tag(); ?>
    <input type=\"submit\" name=\"login\" value=\"Login\"/>
</form>
    ");
}






