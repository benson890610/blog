<?php 

namespace App\Tools;

class Template {

	public static function navbar($dir, $page) {

		if(\App\Tools\Auth::is_logged()) {

			$nav = "{$_ENV['APP_ROOT']}views/{$dir}/{$page}";

			if(file_exists($nav . '.inc.php')) {
				include $nav . '.inc.php';
			}
			elseif(file_exists($nav . '.php')) {
				include $nav . '.php';
			}
			else {
				trigger_error('Tempalte Error: Unable to locate navbar template file ' . $nav);
	            exit;
			}

		}

	}

}