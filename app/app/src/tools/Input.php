<?php 

namespace App\Tools;

use App\Tools\File;


class Input {

	public File $file;
	
	private $value;

	public bool $invalid = false;

	public function __construct() {
		$this->file = new File;
	}

	public function post(string $key) {
		$this->value = trim($_POST[$key]);

		return $this;
	}

	public function filter(array $values) {
		$_POST = filter_input_array(INPUT_POST, $values);
	}

	public function check(array $keys, string $method = 'post') : void {
		if(strtolower($method) === 'post') {
			foreach($keys as $key) {
				if(!isset($_POST[$key])) {
					$this->invalid = true;
				}
			}
		}
	}

	public function safe($pattern, $replacement = '') : Input {
		if(!is_null($this->value)) {
			$this->value = preg_replace($pattern, $replacement, $this->value);
		}

		return $this;
	}

	public function ucfirst() : Input {
		if(!is_null($this->value)) {
			$this->value = ucfirst($this->value);
		}

		return $this;
	}

	public function chars() : Input {
		if(!is_null($this->value)) {
			$this->value = htmlspecialchars($this->value);
		}

		return $this;
	}

	public function integer() : Input {
		if(!is_null($this->value)) {
			if(is_numeric($this->value)) $this->value = (int) $this->value;
		}

		return $this;
	}

	public function remember_me() {
		return isset($_POST['remember_me']) ? true : false;
	}

	public function retrieve() {
		$value = $this->value;

		$this->value = null;

		return $value;
	}

	/*

	Validation input methods

	*/

	public function validate_first_name(\App\Models\User &$user, Log $log) {
		$min_name_len = 2;
		$name_regex   = '/[^a-zA-Z]/i';

		if(empty($user->first_name)) {
	        $user->first_name_err = 'First Name is required';
	        $user->validated      = false;
	        $log->reason('First Name empty');
	    } else {
	        if(strlen($user->first_name) < $min_name_len) {
	            $user->first_name_err = 'First Name is too short';
	            $user->validated      = false;
	            $log->reason('First Name is too short');
	        } elseif(preg_match($name_regex, $user->first_name)) {
	            $user->first_name_err = 'First Name may only have alphabet characters';
	            $user->validated      = false;
	            $log->reason('First Name invalid');
	        }
	    }
	}

	public function validate_last_name(\App\Models\User &$user, Log $log) {
		$min_name_len = 2;
		$name_regex   = '/[^a-zA-Z]/i';

		if(empty($user->last_name)) {
	        $user->last_name_err = 'Last Name field is required';
	        $user->validated     = false;
	        $log->reason('Last Name empty');
	    } else {
	        if(strlen($user->last_name) < $min_name_len) {
	            $user->last_name_err = 'First Name field is too short';
	            $user->validated     = false;
	            $log->reason('Last Name too short');
	        } elseif(preg_match($name_regex, $user->last_name)) {
	            $user->last_name_err = 'Last Name may only have alphabet characters';
	            $user->validated      = false;
	            $log->reason('Last Name invalid');
	        }
	    }
	}

	public function validate_username(\App\Models\User &$user, Log $log) {
		$min_username_len = 4;
		$username_regex   = '/[^a-zA-Z0-9_\.]/i';

		if(empty($user->username)) {
	        $user->username_err = 'Username is required';
	        $user->validated    = false;
	        $log->reason('Username empty');
	    } else {
	    	if(strlen($user->username) < $min_username_len) {
	    		$user->username_err = 'Username is too short';
	    		$user->validated    = false;
	    		$log->reason('Username is too short');
	    	}
	        elseif(preg_match($username_regex, $user->username)) {
	            $user->username_err = 'Username is invalid only alphabetic, numeric, dot and underscore characters are allowed';
	            $user->validated    = false;
	            $log->reason('Username invalid');
	        }
	    }
	}

	public function validate_confirm_password(\App\Models\User &$user, Log $log) {
		if(empty($user->confirm_password)) {
	        $user->confirm_password_err = 'Confirm Password field is required';
	        $user->validated            = false;
	        $log->reason('Confirm Password empty');
	    } else {
	        if($user->password !== $user->confirm_password) {
	            $user->confirm_password_err = 'Password and Confirm Password do not match';
	            $user->validated = false;
	            $log->reason('Password and Confirm Password do not match');
	        }
	    }
	}

	public function validate_email(\App\Models\User &$user, Log $log) {
		if(empty($user->email)) {
	        $user->email_err = 'Email address is required';
	        $user->validated = false;
	        $log->reason('Email address empty');
	    } else {
	        if(!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
	            $user->email_err = 'Email address is not valid';
	            $user->validated = false;
	            $log->reason('Email address invalid');
	        }
	    }
	}

	public function validate_password(\App\Models\User &$user, Log $log) {
		$min_pass_len = 6;

		if(empty($user->password)) {
	        $user->password_err = 'Password is required';
	        $user->validated    = false;
	        $log->reason('Password field empty');
	    } else {
	        if(strlen($user->password) < $min_pass_len) {
	            $user->password_err = "Password require minimum {$min_pass_len} characters length";
	            $user->validated    = false;
	            $log->reason('Password length is too short');
	        }
	    }
	}

	public function validate_country(\App\Models\User &$user, Log $log) {
		if($user->country_id === 0) {
			$user->country_err = 'Please select a country';
			$user->validated   = false;
			$log->reason('Country not selected');
		}
	}

	public function validate_city(\App\Models\User &$user, Log $log) {
		$min_city_len = 3;
		$city_regex   = '/[^a-zA-Z \-]/i';

		if(empty($user->city)) {
			$user->city_err  = 'City name is required';
			$user->validated = false;
			$log->reason('City is empty');
		} else {
			if(strlen($user->city) < $min_city_len) {
				$user->city_err  = "City name require minimum {$min_city_len} characters length";
				$user->validated = false;
				$log->reason('City name is too short');
			} elseif(preg_match($city_regex, $user->city)) {
				$user->city_err  = "City name contain invalid characters";
				$user->validated = false;
				$log->reason('City name contain invalid characters');
			}
		}
	}

	public function validate_address_line(\App\Models\User &$user, Log $log) {
		if(empty($user->address_line)) {
			$user->address_line_err = 'Address line is required';
			$user->validated   = false;
			$log->reason('Address line is empty');
		} 
	}

	public function validate_zipcode(\App\Models\User &$user, Log $log) {
		if(empty($user->zipcode)) {
			$user->zipcode_err = 'Zipcode is required';
			$user->validated   = false;
			$log->reason('Zipcode is empty');
		}
	}

	public function validate_id($key) {
		if(!is_numeric($_POST[$key]) || $_POST[$key] <= 0) {
			$this->invalid = true;
		}
	}

	public function validate_post_id(\App\Models\Post &$post, Log $log) {
		if(!is_numeric($post->id) || $post->id <= 0) {
			$post->validated = false;
			$log->reason('Post ID is not valid');
		}
	}

	public function validate_title(\App\Models\Post &$post, Log $log) {
		if(empty($post->title)) {
			Error::set('title', 'Title field is required');
	        $post->validated = false;
	        $log->reason('Title field empty');
	    }
	}

	public function validate_description(\App\Models\Post &$post, Log $log) {
		if(empty($post->description)) {
			Error::set('description', 'Description field is required');
	        $post->validated       = false;
	        $log->reason('Description field empty');
	    }
	}

	public function validate_category(\App\Models\Post &$post, Log $log) {
		if(!is_numeric($post->category_id) || empty($post->category_id)) {
			Error::set('category', 'Please selete category');
	        $post->validated    = false;
	        $log->reason('Category manualy changed to empty or string format');
	    }

	    elseif(!$post->category_exists()) {
	    	Error::set('category', 'Please selete category');
	        $post->validated    = false;
	        $log->reason('Category value manualy changed to unknown numeric value');
	    }
	}

	// ===============================================
	// Authentication input methods
	// ===============================================

	public function authenticate($password, \App\Models\User &$user, Log $log) {
		if($user->id === 0) {
	        $user->email_err     = 'Email or Password is incorrect';
	        $user->password_err  = 'Email or Password is incorrect';
	        $user->authenticated = false;
	        $log->reason('Email address incorrect');
	    } else {
	        if(!password_verify($password, $user->password)) {
	            $user->password      = $password;
	            $user->email_err     = 'Email or Password is incorrect';
	            $user->password_err  = 'Email or Password is incorrect';
	            $user->authenticated = false;
	            $log->reason('Password incorrect');
	        }
	    }
	}

	public function auth_password_change(\App\Models\User &$user, \App\Tools\Log $log) {
	    if($user->id === 0 || !$user->exists()) {
	    	$user->authenticated = false;
	    	$log->reason('Password change request not found');
	    }
	    elseif($user->password_forgot_id === 0 || !$user->check_password_forgot_id()) {
	    	$user->authenticated = false;
	    	$log->reason('Password change request credentials do not match');
	    }
	}

	public function password_forgot_find_email(\App\Models\User &$user, Log $log) {
		if(!$user->email_exists()) {
	        $user->email_err     = 'That email address does not exists';
	        $user->authenticated = false;
	        $log->reason("{$user->email} was not found");
	    }
	}

	public function password_request_already_sent(\App\Models\User &$user, Log $log) {
		if($user->already_sent_password_request()) {
	        $user->email_err     = 'Password change request has been already sent to your email';
	        $user->authenticated = false;
	        $log->reason("{$user->email} requesting more that 1 time for password change");
	    }
	}

	public function email_already_exists(\App\Models\User &$user, Log $log) {
		if($user->email_exists()) {
	        $user->email_err     = 'That email is already taken';
	        $user->authenticated = false;
	        $log->reason("{$user->email} email already taken");    
	    }
	}

	public function username_already_exists(\App\Models\User &$user, Log $log) {
		if($user->username_exists()) {
	        $user->username_err  = 'That username is already taken';
	        $user->authenticated = false;
	        $log->reason("{$user->username} username already taken");
	    }
	}

}