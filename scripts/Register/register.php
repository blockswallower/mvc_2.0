<h1>Register</h1>
<form class="omb_loginForm" action="<?php echo __URL__; ?>register/register" method="post" >
	<input type="text" class="form-control" name="username" placeholder="username" />
	<input type="email" name="email" placeholder="email address">
	<input type="email" name="email_confirm" placeholder="email address confirm" />
	<input  type="password" name="password" placeholder="Password">
	<input  type="password" name="password_confirm" placeholder="Password confirm">
	<?php echo csrf_token_tag(); ?>
	<button type="submit" style = "margin-top: 10px">register</button>
</form>