<?php
/*
 * Must call session_start() before this loads
 */

/*
 * Generate a token for use with CSRF protection.
 * Does not store the token.
 */
function csrf_token() {
	return md5(uniqid(rand(), true));
}

/*
 * Generate and store CSRF token in user session.
 * Requires session to have been started already.
 */
function create_csrf_token() {
	$token = csrf_token();

	$_SESSION['csrf_token'] = $token;
	$_SESSION['csrf_token_time'] = time();

	return $token;
}

/*
 * Destroys a token by removing it from the session.
 */
function destroy_csrf_token() {
	$_SESSION['csrf_token'] = null;
	$_SESSION['csrf_token_time'] = null;

	return true;
}

/*
 * Return an HTML tag including the CSRF token
 * for use in a form.
 * Usage: echo csrf_token_tag();
 */
function csrf_token_tag() {
	$token = create_csrf_token();

	return "<input type=\"hidden\" name=\"csrf_token\" value=\"".$token."\">";
}

/*
 * Returns true if user-submitted POST token is
 * identical to the previously stored SESSION token.
 * Returns false otherwise.
 */
function csrf_token_is_valid() {
	if (isset($_POST['csrf_token'])) {
		$user_token = $_POST['csrf_token'];
		$stored_token = $_SESSION['csrf_token'];

		return $user_token === $stored_token;
	} else {
		Debug::pagedump("POST CSRF token is not identical to stored SESSION", __LINE__, __CLASS__);
	}
}

/*
 * You can simply check the token validity and
 * handle the failure yourself, or you can use
 * this "stop-everything-on-failure" function.
 */
function die_on_csrf_token_failure() {
	if (!csrf_token_is_valid()) {
		Debug::pagedump("CSRF token validation failed", __LINE__, __CLASS__);
	}
}

/*
 * Optional check to see if token is also recent
 */
function csrf_token_is_recent() {
	/*
	 * @var Integer
	 * 1 day
	 */
	$max_elapsed = 60 * 60 * 24;

	if (isset($_SESSION['csrf_token_time'])) {
		$stored_time = $_SESSION['csrf_token_time'];
		return ($stored_time + $max_elapsed) >= time();
	} else {
		/*
		 * Remove expired token
		 */
		destroy_csrf_token();
		Debug::pagedump("CSRF Token is not recent!", __LINE__, __CLASS__);
	}
}

/*
 * GET requests should not make changes
 * Only POST requests should make changes
 */
function request_is_get() {
	return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/*
 * POST requests should not make changes
 * Only GET requests should make changes
 */
function request_is_post() {
	return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/*
 * Validates request
 */
function validate_request() {
	if (request_is_post()) {
		if (csrf_token_is_valid()) {
			if (csrf_token_is_recent()) {
				return true;
			} else {
				Debug::pagedump("CSRF Token is not recent!", __LINE__, __CLASS__);
			}
		} else {
			Debug::pagedump("CSRF Token is not valid!", __LINE__, __CLASS__);
		}
	} else {
		/*
		 * form not submitted or was GET request
		 */
		Debug::pagedump("Form not submitted or was GET request", __LINE__, __CLASS__);
	}
}
?>
