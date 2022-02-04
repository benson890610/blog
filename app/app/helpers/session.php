<?php 

function is_set_session_user($value) {

	$data = App\Tools\Session::get('user', $value);
	
	return (is_null($data)) ? false : true;

}

function session_user_print($value) {

	$data = App\Tools\Session::get('user', $value);

	echo $data;

}

function error_check($value) {
	echo isset($_SESSION[$value]) ? 'is-invalid' : '';
}

function error($value) {

	$data = $_SESSION[$value] ?? '';

	unset($_SESSION[$value]);

	echo $data;
}