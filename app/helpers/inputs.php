<?php 

function input_error(string $value) {

    return empty($value) ? '' : 'is-invalid'; 

}

function random_text(int $num) {

	$text   = 'asdfghjklzxcvbnm1234567890qwertyuiopXCVBNMQWERTYUIOPASDFGHJKL';
	$letter = '';
	for($i = 0; $i < $num; $i++) {

		$random_num = rand(0, strlen($text) - 1); 

		$letter .= $text[$random_num];

	}

	return $letter;

}

function unique_name(string $name) {

	$text = random_text(10) . '_' . time() . '_' . $name;

	return $text;

}

function remove_special_chars(string $text) {

	$pattern = '/[!@#$%^*&\/()|\\?:\"\'><]+/';

	$modified_text = preg_replace($pattern, '', $text);

	return $modified_text;

}

function username_link(string $username, string $page) {
	if(isset($_ENV['APP_SRC'])) {

		$link = $_ENV['APP_SRC'] . $page . '/' . $username;

		return $link;

	}

	return '';
}