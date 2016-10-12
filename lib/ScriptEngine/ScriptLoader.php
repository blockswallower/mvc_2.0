<?php
class ScriptLoader {
	public function __construct() {
		$this->load_scripts();
	}
	
	private function load_scripts() {
		if (Settings::$config['SCRIPT']['EVERY_TIME_EXECUTION'] != 'NONE') {
			$dirname = Settings::$config['SCRIPT']['EVERY_TIME_EXECUTION'];
			$dir = './scripts/';
			
			if (is_array($dirname)) {
				foreach ($dirname as $name) {
					if ($name != "NONE") {
						if (!is_dir($dir . $name)) {
							Debug::exitdump('Script directory not found');
						}
						$files = array_diff(scandir($dir . $name), ['..', '.']);
						foreach ($files as $file) {
							$myfile = file_get_contents($dir . $name . '/' . $file);
							
							if (strpos($file, 'Model')) {
								$this->makeModel($myfile, $file);
							} else if (strpos($file, 'Controller')) {
								$this->makeController($myfile, $file);
							} else {
								$this->makeView($myfile, $file);
							}
						}
					}
				}
			} else {
				if ($dirname != "NONE") {
					if (!is_dir($dir . $dirname)) {
						Debug::exitdump('Script directory not found');
					}
					$files = array_diff(scandir($dir . $dirname), ['..', '.']);
					foreach ($files as $file) {
						$myfile = file_get_contents($dir . $dirname . '/' . $file);
						
						if (strpos($file, 'Model')) {
							$this->makeModel($myfile, $file);
						} else if (strpos($file, 'Controller')) {
							$this->makeController($myfile, $file);
						} else {
							$this->makeView($myfile, $file);
						}
					}
				}
			}
		}
		
		if (Settings::$config['SCRIPT']['ONE_TIME_EXECUTION'] != 'NONE') {
			$settingsContent = './app/Settings.php';
			$dirname = Settings::$config['SCRIPT']['ONE_TIME_EXECUTION'];
			$dir = './scripts';
			
			if (is_array($dirname)) {
				foreach ($dirname as $name) {
					if ($name != "NONE") {
						if (!is_dir($dir . '/' . $name)) {
							Debug::exitdump('Script directory not found');
						}
						$files = array_diff(scandir($dir . '/' . $name), ['..', '.']);
						foreach ($files as $file) {
							$myfile = file_get_contents($dir . '/' . $name . '/' . $file);
							
							if (strpos($file, 'Model')) {
								$this->makeModel($myfile, $file);
							} else if (strpos($file, 'Controller')) {
								$this->makeController($myfile, $file);
							} else {
								$this->makeView($myfile, $file);
							}
						}
					}
				}
			} else {
				if ($dirname != "NONE") {
					if (!is_dir($dir . '/' . $dirname)) {
						Debug::exitdump('Script directory not found');
					}
					$files = array_diff(scandir($dir . '/' . $dirname), ['..', '.']);
					foreach ($files as $file) {
						$myfile = file_get_contents($dir . '/' . $dirname . '/' . $file);
						
						if (strpos($file, 'Model')) {
							$this->makeModel($myfile, $file);
						} else if (strpos($file, 'Controller')) {
							$this->makeController($myfile, $file);
						} else {
							$this->makeView($myfile, $file);
						}
					}
				}
			}
			
			if (is_array($dirname)) {
				foreach ($dirname as $script) {
					$newSettingsContent = str_replace($script, 'NONE', file_get_contents($settingsContent));
					file_put_contents($settingsContent, $newSettingsContent);
				}
			} else {
				$newSettingsContent = str_replace($dirname, 'NONE', file_get_contents($settingsContent));
				file_put_contents($settingsContent, $newSettingsContent);
			}
		}
	}
	
	function makeModel($fileContents, $name) {
		if (!file_exists('models/' . $name)) {
			$model = fopen('./models/' . $name, 'w');
			
			fwrite($model, $fileContents);
		}
	}
	
	function makeController($fileContents, $name) {
		if (!file_exists('controllers/' . $name)) {
			$view = fopen('./controllers/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}
	
	function makeView($fileContents, $name) {
		if (!file_exists('views/' . $name)) {
			$view = fopen('./views/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}
}