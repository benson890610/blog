<?php 

namespace App\Tools;

use App\Database;

class Auth {

	private static array $allow_methods = ['logout'];

	public static function user_post(int $id) : bool {

		if(isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

			return (int)$_SESSION['user']['id'] === (int)$id;

		}

		return false;

	}

	public static function is_logout_requested() {

		$route = $_GET['route'];
		$route_arr = explode('/', rtrim($route));
		$method = $route_arr[1] ?? '';
		
		if(in_array($method, self::$allow_methods)) return true;

		return false;
		
	}

	public static function is_logged() : bool {

		if(isset($_SESSION['token']) && isset($_SESSION['user'])) {

			$access_token = $_SESSION['token'];
			$user         = $_SESSION['user'];

			$db = new Database;

			$sql_query = "SELECT login_token FROM user_status WHERE user_id = :id";

			$db->prepare($sql_query);
			$db->bind(':id', $user['id']);
			$db->execute();

			$result_set = $db->single();

			if($result_set['login_token'] === $access_token) return true;

			return false;

		}
		else if(isset($_COOKIE['remember_me'])) {

			$access_token = $_COOKIE['remember_me'];

			$db = new Database;

			$sql_query = "SELECT 1 FROM user_status WHERE remember_token = :token";

			$db->prepare($sql_query);
			$db->bind(':token', $access_token);
			$db->execute();

			$result_set = $db->single();

			if($result_set) return true;

			return false;
		}

		return false;

	}

}