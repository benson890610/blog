<?php 

namespace App\Controllers;

use App\Controller;

use App\Models\User;

use App\Tools\Log;
use App\Tools\Data;
use App\Tools\Session;
use App\Tools\Auth;
use App\Tools\Input;

class UsersController extends Controller {

    private User $user;
    private Log  $log;
    private Data $data;

    private const  COOKIE_LIFETIME   = 86400;
    private const  COOKIE_DAYS       = 1;
    private const  EMAIL_EXP_DATE    = 3600;
    private const  PASSWORD_EXP_DATE = 3600;

    public function __construct() {

        if(!Auth::is_logout_requested()) {
            if(Auth::is_logged()) redirect('posts');
        }

        $this->user = $this->model('User');        // Load User DB model
        $this->log  = $this->logs('user');         // Load User file logs writing
        $this->data = new Data;                    // Custom page data
    }

    public function index() {
        $this->data->title   = 'Sign In';
        $this->data->message = Session::message_output();

        $this->view('users/login')->import([$this->data, $this->user])->display();
    }

    public function login() {
        $this->data->title    = 'Sign In';
        $this->data->message  = Session::message_output();

        $input = new Input;     // Post Input handler

        $input->filter(['email' => FILTER_SANITIZE_EMAIL, 'password' => FILTER_SANITIZE_STRING, 'remember_me' => FILTER_SANITIZE_STRING]);

        $this->user->email    = $input->post('email')->retrieve();
        $this->user->password = $input->post('password')->retrieve();
        $this->user->remember = $input->remember_me();

        $input->validate_email($this->user, $this->log);
        $input->validate_password($this->user, $this->log);
        
        if($this->user->validated) {
            $input_password = $this->user->password; // Save temp user submitted password

            $this->user->get_credentials();

            $input->authenticate($input_password, $this->user, $this->log);

            if($this->user->authenticated) {

                if($this->user->is_activated === 0) {   // If account is not activated from user email after registration
                    Session::message_set("Your account was not activated from an email we sent to you", 'danger');
                    redirect('');
                }
                
                if($this->user->remember) $this->remember(); // If user submitted remember me 

                $this->complete_login();
                
            } else {
                $this->log->status('FAIL')->method('USER LOGIN')->remote(true, true)->message($this->user->email)->write(); // Write log status
            }
        } else {
            $this->log->status('FAIL')->method('USER LOGIN')->remote(true, true)->message($this->user->email)->write();
        }
        $this->view('users/login')->import([$this->data, $this->user])->display();
    }

    public function logout() {
        $this->user->id = Session::get('user', 'id');

        unset($_SESSION['token']);
        unset($_SESSION['user']);

        $this->user->update_status('logout');

        redirect('');
    }

    public function registration() {
        $this->data->title = 'Registration';
        $this->user->get_countries();
        $this->view('users/registration')->import([$this->data, $this->user])->display();
    }

    public function register() {
        $this->data->title = 'Registration';
        $this->user->get_countries();

        $input = new Input;
        $input->filter(['first_name' => FILTER_SANITIZE_STRING, 'last_name' => FILTER_SANITIZE_STRING, 'email' => FILTER_SANITIZE_EMAIL, 'username' => FILTER_SANITIZE_STRING, 'password' => FILTER_SANITIZE_STRING, 'confirm_password' => FILTER_SANITIZE_STRING, 'country' => FILTER_SANITIZE_STRING, 'city' => FILTER_SANITIZE_STRING, 'address_line' => FILTER_SANITIZE_STRING, 'zipcode' => FILTER_SANITIZE_STRING]);
        $input->check(['first_name', 'last_name', 'email', 'username', 'password', 'confirm_password', 'country', 'city', 'address_line', 'zipcode']);

        if($input->invalid) redirect('');

        $this->user->first_name       = $input->post('first_name')->ucfirst()->retrieve();
        $this->user->last_name        = $input->post('last_name')->ucfirst()->retrieve();
        $this->user->email            = $input->post('email')->retrieve();;
        $this->user->username         = $input->post('username')->retrieve();
        $this->user->password         = $input->post('password')->retrieve();
        $this->user->confirm_password = $input->post('confirm_password')->retrieve();
        $this->user->country_id       = (int) $input->post('country')->retrieve();
        $this->user->city             = $input->post('city')->ucfirst()->retrieve();
        $this->user->address_line     = $input->post('address_line')->retrieve();
        $this->user->zipcode          = $input->post('zipcode')->retrieve();

        $input->validate_first_name($this->user, $this->log);
        $input->validate_last_name($this->user, $this->log);
        $input->validate_email($this->user, $this->log);
        $input->validate_username($this->user, $this->log);
        $input->validate_password($this->user, $this->log);
        $input->validate_confirm_password($this->user, $this->log);

        $this->check_address($input);

        if($this->user->validated) {
            $input->email_already_exists($this->user, $this->log);
            $input->username_already_exists($this->user, $this->log);

            if($this->user->authenticated) $this->complete_registration();

            $this->log->status('FAIL')->method('REGISTRATION')->remote(true, true)->write();
        } else {
            $this->log->status('FAIL')->method('REGISTRATION')->remote(true, true)->write();
        }
        $this->view('users/registration')->import([$this->data, $this->user])->display();
    }

    public function confirm(string $code = "") {
        if(empty($code)) redirect('');

        $this->user->get_confirmation_details($code);
        
        if($this->user->confirmation_id === 0) redirect('');    // If code do not match
        
        $current_date = new \DateTime();
        $difference   = $current_date->diff($this->user->confirm_exp_date);
        
        // Confirmation code expired
        if($difference->invert > 0) {

            $email    = $this->user->find_email_by_id();
            $token    = random_text(16);
            $exp_date = $this->create_expire_date();

            $this->user->change_confirmation_code($token, $exp_date);
            $this->log->status('FAIL')->method('USER ACCOUNT ACTIVATION')->remote(true, true)->message($email . ' token has expired')->write();

            $this->mailer()->send_confirm_registration_activation($this->user->email, $token);

            Session::message_set("Confirmation code has expired<br>New confirmation code was created and sent to your email account", 'warning');
            redirect('');
        }

        $email = $this->user->find_email_by_id();

        $this->user->activate_account();
        $this->user->delete_confirmation_code();
        $this->log->status('SUCCESS')->method('USER ACCOUNT ACTIVATION')->remote(true, true)->message($email)->write();

        Session::message_set("You successfully activated account. You may sing in", 'success');
        redirect('');
    }

    public function password_forgot() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $input = new Input;

            $input->check(['email']);

            if($input->invalid) {
                $this->log->status('MALIOUS')->method('USER PASSWORD FORGOT REQUEST')->remote(true, true)->message('Email attribute not recived')->write();
                redirect('posts');
            }

            $input->filter(['email' => FILTER_SANITIZE_EMAIL]);

            $this->user->email = $input->post('email')->retrieve();

            $input->validate_email($this->user, $this->log);

            if($this->user->validated) {

                $input->password_forgot_find_email($this->user, $this->log);

                if($this->user->authenticated) {

                    $this->user->find_id_by_email();

                    $input->password_request_already_sent($this->user, $this->log);

                    if($this->user->authenticated) $this->complete_password_forgot_request();
                }

                $this->log->status('FAIL')->method('USER PASSWORD FORGOT REQUEST')->remote(true, true)->write();
            } else {
                $this->log->status('FAIL')->method('USER PASSWORD FORGOT REQUEST')->remote(true, true)->write();
            }
        }

        $this->data->title = 'Password Forgot';

        $this->view('users/password_forgot')->import([$this->data, $this->user])->display();
    }

    public function password_change(string $token = '') {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $input = new Input;
            $input->filter(['password' => FILTER_SANITIZE_STRING, 'confirm_password' => FILTER_SANITIZE_STRING, 'password_forgot_id' => FILTER_SANITIZE_NUMBER_INT, 'user_id' => FILTER_SANITIZE_NUMBER_INT]);

            $this->user->password           = $input->post('password')->chars()->retrieve();
            $this->user->confirm_password   = $input->post('confirm_password')->chars()->retrieve();
            $this->user->password_forgot_id = $input->post('password_forgot_id')->integer()->retrieve();
            $this->user->id                 = $input->post('user_id')->integer()->retrieve();

            $input->auth_password_change($this->user, $this->log);

            if($this->user->authenticated) {
                $input->validate_password($this->user, $this->log);
                $input->validate_confirm_password($this->user, $this->log);

                if($this->user->validated) $this->complete_password_change();

                $this->log->status('FAIL')->method('USER PASSWORD CHANGE REQUEST')->remote(true, true)->write();

            } else {
                $this->log->status('FAIL')->method('USER PASSWORD CHANGE REQUEST')->remote(true, true)->write();
            }
        }

        if(empty($token)) redirect('');

        $this->user->get_forgot_password_details($token);

        if($this->user->password_forgot_id === 0) redirect('');

        $this->check_password_request_expired();

        $this->data->title = "Password reqovery";

        $this->view('users/password_change')->import([$this->data, $this->user])->display();
    }

    private function complete_login() {
        $tk_login = bin2hex(random_bytes(16)); // Generate session and db token

        $this->log->status('SUCCESS')->method('USER LOGIN')->remote(true, true)->message($this->user->email)->write(); // Update log status

        $this->user->update_status('login', $tk_login); // Save token, user logged, logged date

        $user = array(
            'id'            => $this->user->id,
            'first_name'    => $this->user->first_name,
            'last_name'     => $this->user->last_name,
            'email'         => $this->user->email,
            'username'      => $this->user->username,
            'rating'        => $this->user->rating,
            'posts'         => $this->user->posts,
            'registered_at' => $this->user->registered_at,
            'logged_in'     => $this->user->logged_in,
            'image_src'     => $this->user->src_path,
            'image_root'    => $this->user->root_path
        );
        
        Session::set('token', $tk_login); // Generate token session
        Session::set('user',  $user);     // Generate user session
        Session::message_set("Welcome back {$this->user->first_name} {$this->user->last_name}", 'success'); // Output message to redirect page

        redirect('posts');
    }

    private function complete_registration() {
        $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);

        $token    = random_text(16);
        $exp_date = $this->create_expire_date(self::EMAIL_EXP_DATE);

        $this->user->save();
        $this->user->save_confirm_registration_code($token, $exp_date);

        $this->log->status('SUCCESS')->method('REGISTRATION')->remote(true, true)->message("{$this->user->email} has been created")->write();

        $this->mailer()->send_confirm_registration_activation($this->user->email, $token);

        Session::message_set("An email is sent on {$this->user->email} with confirmation code", 'success');

        redirect('');
    }

    // COMPLETE PASSWORD FORGOT REQUEST
    private function complete_password_forgot_request() {
        $token    = random_text(16);
        $exp_date = $this->create_expire_date();

        $this->user->save_password_forgot_request($token, $exp_date);
        $this->mailer()->send_password_forgot_activation($this->user->email, $token);

        Session::message_set("An email with password change is sent to you", 'success');

        redirect('');
    }

    private function complete_password_change() {
        $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
        $this->user->delete_password_forgot_code();
        $this->user->change_password();

        Session::message_set("Your password has been changed", 'success');

        redirect('');
    }

    private function remember() : void {
        $tk_remember = bin2hex(random_bytes(16));
        $tk_time     = time() + self::COOKIE_LIFETIME * self::COOKIE_DAYS;

        $this->user->save_remember_token($tk_remember);
        setcookie('remember_me', $tk_remember, $tk_time, '/');
    }

    private function check_address(Input $input) : void {
        if($this->user->country_id !== 0 || !empty($this->user->city) || !empty($this->user->address_line) || !empty($this->user->zipcode)) {
            $input->validate_country($this->user, $this->log);
            $input->validate_city($this->user, $this->log);
            $input->validate_address_line($this->user, $this->log);
            $input->validate_zipcode($this->user, $this->log);
        }
    }

    private function check_password_request_expired() {
        $current_date = new \DateTime;
        $difference   = $current_date->diff($this->user->password_forgot_exp_date);

        if($difference->invert > 0) {
            $token    = random_text(16);
            $exp_date = $this->create_expire_date();

            $this->user->find_email_by_id();

            $this->user->change_password_forgot_code($token, $exp_date);
            $this->mailer()->send_password_forgot_activation($this->user->email, $token);

            Session::message_set("Request for password change expired. You will recieve new email with link for password activation", 'warning');

            redirect('');
        }
    }


    private function create_expire_date() : string {
        $houre_seconds = self::EMAIL_EXP_DATE;
        $timestamp     = time() + $houre_seconds;

        $date = new \DateTime;
        $date->setTimestamp($timestamp);

        return $date->format('Y-m-d H:i:s');
    }

}