<?php 

namespace App\Tools;

use App\Database;

class Session {

	public static function set(string $key, $value) {

		$_SESSION[$key] = $value;

	}

	public static function get($key, $value = null) {

		if(is_null($value)) return $_SESSION[$key];

		return $_SESSION[$key][$value];

	}

	public static function message_set(string $text, string $class) {

		$_SESSION['msg'] = '<div class="alert alert-'. $class .'">'. $text .'</div>';

	}

	public static function message_output() {

		if(isset($_SESSION['msg'])) {
	        $msg = $_SESSION['msg'];

	        unset($_SESSION['msg']);

	        return $msg;
	    }

	    return "";

	}

}