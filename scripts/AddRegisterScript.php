<?php

if (!file_exists('controllers/RegisterController')) {
    $controller = fopen('./controllers/RegisterController.php', 'w');

    fwrite($controller, '
<?php

class RegisterController extends Controller {
    public function __construct(){
        parent::__construct();

        $this->loadModel(\'register\');

        $this->config_view_array();

        $this->view->show(\'register\');
    }

    public function register() {
        if (empty($_POST[\'username\']) || empty($_POST[\'email\']) || empty($_POST[\'email_confirm\']) || empty($_POST[\'password\'])
        || empty($_POST[\'password_confirm\'])) {
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
        if ($_POST[\'password\'] !== $_POST[\'password_confirm\']) {
           Debug::pagedump("Please fill in the required fields");
           return false;
        }

        if (strlen($_POST[\'password\']) < 5) {
            Debug::pagedump(\'Password most be longer than 5 characters\');
            return false;
        }

        if (strlen($_POST[\'password\']) > 20) {
            Debug::pagedump(\'Password most be shorter than 20 characters\');
            return false;
        }

        if( !preg_match("#[a-z]+#", $_POST[\'password\']) ) {
            Debug::pagedump(\'Password must include at least one lowercase letter\');
            return false;
        }

        if( !preg_match("#[A-Z]+#", $_POST[\'password\']) ) {
            Debug::pagedump(\'Password must include at least one uppercase letter\');
            return false;
        }

        return true;
    }

    public function email_check() {
        if ($_POST[\'email\'] !== $_POST[\'email_confirm\']) {
            Debug::pagedump(\'Email addresses do not match\');
            return false;
        }

        if (filter_var($_POST[\'email\'], FILTER_VALIDATE_EMAIL) === false) {
            Debug::pagedump(\'Email addresses is not valid\');
            return false;
        }

        return true;
    }

    public function username_check() {
        if (strlen($_POST[\'username\']) > 20) {
            Debug::pagedump(\'Username most be shorter than 20 characters\');
            return false;
        }

        if (strlen($_POST[\'username\']) < 5) {
            Debug::pagedump(\'Username most be longer than 5 characters\');
            return false;
        }

        return true;
    }
}
    ');
}

if (!file_exists("models/RegisterModel.php")) {
    $model = fopen('./models/RegisterModel.php', 'w');

    fwrite($model, '
<?php

class RegisterModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function register() {
        $hash = md5(rand(0,1000).time());
        $result = $this->user_check();

        if ($result) {
            $result = $this->email_sent($hash);
        } else {
            Debug::pagedump(\'Username and/or email address is already registered\');
            return false;
        }

        if ($result) {
            $result = $this->after_successful_check($hash);
        } else {
            Debug::pagedump(\'Verify email has not been send, please try again\');
            return false;
        }

        if ($result) {
            Debug::pagedump(\'You are successfully registered, <br /> please verify youre email address by clicking the activation link that  to your email address\');
            return true;
        } else {
            Debug::pagedump(\'Something went wrong, please try again\');
            return false;
        }
    }

    private function user_check() {
        $username = htmlspecialchars($_POST[\'username\']);
        $email = $_POST[\'email\'];
        $result = $this->db->prepare(\'SELECT * FROM users WHERE username = :username OR email = :email;\');
        $result->execute(array(
            \':username\' => $username,
            \':email\' => $email
        ));

        $count = $result->rowCount();
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function after_successful_check($hash) {
        $username = htmlspecialchars($_POST[\'username\']);
        $email = $_POST[\'email\'];
        $password = $_POST[\'password\'];
        $result = $this->db->prepare(\'INSERT INTO users (username, password, email, hash, active) VALUES (:username, :password, :email, :hash, :active);\');
        $insert = $result->execute(array(
            \':username\' => $username,
            \':password\' => $password,
            \':email\' => $email,
            \':hash\' => $hash,
            \':active\' => 0
        ));

        return $insert;
    }

    private function email_sent($hash) {
        $email = $_POST[\'email\'];
        $password = $_POST[\'password\'];
        $username = $_POST[\'username\'];
        $result = Email::verification_email($email, $username, $password, $hash);
        return $result;
    }
}'
    );
}

if (!file_exists("views/register.php")) {
    $view = fopen("./views/register.php", "w");

    fwrite($view, '
<h1>Register</h1>
<form class="omb_loginForm" action="<?php echo URL; ?>register/register" method="post" />
    <input type="text" class="form-control" name="username" placeholder="username" />
    <input type="email" name="email" placeholder="email address">
    <input type="email" name="email_confirm" placeholder="email address confirm" />
    <input  type="password" name="password" placeholder="Password">
    <input  type="password" name="password_confirm" placeholder="Password confirm">
    <button type="submit" style = "margin-top: 10px">register</button>
</form>
    ');
}