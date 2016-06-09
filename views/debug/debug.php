<?php
	if (!empty(Sessions::get("Error") || !Settings::$config["Debug"])) { 
		echo '<pre>Something went wrong!</pre>';
	  	Dedug::exitdump(Sessions::get("Error"));
	} else {
		Redirect::back();
	} 
?>

