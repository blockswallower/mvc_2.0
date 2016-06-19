<?php
	if (!empty(Sessions::get("Error") && Settings::$config["DEBUG"])) {
		echo '<pre>Something went wrong!</pre>';
	  	Dedug::exitdump(Sessions::get("Error"));
	} else {
		Redirect::back();
	} 
?>

