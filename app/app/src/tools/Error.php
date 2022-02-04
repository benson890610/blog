<?php 

namespace App\Tools;

use App\Tools\Session;

class Error {

	public function check($error) {
		return isset($_SESSION[$error]) ? 'is-invalid' : '';
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function get($key) {

		$item = $_SESSION[$key] ?? '';

		if(isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}

		return $item;
	}

}