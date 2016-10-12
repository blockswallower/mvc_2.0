<h1>Login</h1>
<form class="login-form" method="post" action="<?php echo __URL__; ?>login/login">
    <input type="text" class="username" name="username" placeholder="username">
    <input  type="password" class="password" name="password" placeholder="Password">
    <?php echo Csrf::csrf_token_tag(); ?>
    <input type="submit" name="login" value="Login"/>
</form>