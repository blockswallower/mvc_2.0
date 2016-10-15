<!DOCTYPE html>
	<html lang="en">
	<head>
		<?php Link::style("style.css"); ?>
	</head>
	<body>
		<?php
			if (!empty(Sessions::get("Error") && Config::get("DEBUG"))) {
				echo '<pre>Something went wrong!</pre>';
				echo '<pre>'. Sessions::get("debug_info") .'</pre>';
				Debug::dump(Sessions::get("Error"));
			} else {
				Redirect::back();
			}
		?>
	</body>
</html>


