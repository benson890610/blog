<?php 

namespace App\Models;

use App\Utilities\ClassNameInterface;
use App\Database;

class User implements ClassNameInterface {

    // Database connection
    private Database $db;

    // Class Name
    public string $class_name = ""; 
    
    // Interface content
    public array   $countries            = [];

    // Login and Registration credentials
    public string  $first_name           = '';
    public string  $last_name            = '';
    public string  $email                = '';
    public string  $username             = '';
    public string  $password             = '';
    public string  $confirm_password     = '';
    public int     $country_id           = 0;
    public string  $city                 = '';
    public string  $address_line         = '';
    public string  $zipcode              = '';

    // Login and Registration error messages
    public string  $first_name_err       = '';
    public string  $last_name_err        = '';
    public string  $email_err            = '';
    public string  $username_err         = '';
    public string  $password_err         = '';
    public string  $confirm_password_err = '';
    public string  $country_err          = '';
    public string  $city_err             = '';
    public string  $address_line_err     = '';
    public string  $zipcode_err          = '';

    // Db interaction
    public int     $id                   = 0;
    public int     $confirmation_id      = 0;
    public int     $password_forgot_id   = 0;
    public int     $rating               = 0;
    public int     $posts                = 0;
    public int     $is_activated         = 0;
    public string  $password_code        = '';
    public string  $registered_at        = '';
    public ?string $logged_in            = '';
    public ?string $image_src            = '';
    public ?string $image_root           = '';
    public \DateTime $confirm_exp_date;
    public \DateTime $password_forgot_exp_date;

    public bool    $validated            = true;
    public bool    $authenticated        = true;
    public bool    $remember             = false;

    public function __construct() {
        $this->db         = new Database;
        $this->generate_class_name();
    }

    public function generate_class_name() {
        if(!property_exists($this, "class_name")) {
            trigger_error('Required property "class_name" does not exists');
            return;
        }

        $this->class_name = __CLASS__;

        $class_array = explode("\\", $this->class_name);
        $this->class_name = strtolower(end($class_array));
    }

    public function exists() {
        $sql_query = "SELECT user_id FROM users WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    public function save() {
        $sql_query = "CALL save_user(:first_name, :last_name, :email, :username, :password, :country_id, :city, :address_line, :zipcode)";

        $this->db->prepare($sql_query);
        $this->db->bind(':first_name',   $this->first_name);
        $this->db->bind(':last_name',    $this->last_name);
        $this->db->bind(':email',        $this->email);
        $this->db->bind(':username',     $this->username);
        $this->db->bind(':password',     $this->password);
        $this->db->bind(':country_id',   $this->country_id);
        $this->db->bind(':city',         $this->city);
        $this->db->bind(':address_line', $this->address_line);
        $this->db->bind(':zipcode',      $this->zipcode);
        $this->db->execute();
    }

    public function save_remember_token(string $token) :void {
        $sql_query = "UPDATE user_status SET remember_token = :token WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':token', $token);
        $this->db->bind(':id',    $this->id);
        $this->db->execute();
    }

    public function save_confirm_registration_code(string $token, string $exp_date) : void {
        try {
            $this->db->begin_transaction();

            $sql_query = "SELECT user_id FROM users WHERE email = :email";

            $this->db->prepare($sql_query);
            $this->db->bind(':email', $this->email);
            $this->db->execute();

            $user = $this->db->single();
            $id   = $user['user_id'];

            $sql_query = "INSERT INTO user_confirmation SET confirmation_code = :code, user_id = :id, expire_date = :expire_date";
            
            $this->db->prepare($sql_query);
            $this->db->bind(':code',        $token);
            $this->db->bind(':id',          $id);
            $this->db->bind(':expire_date', $exp_date);
            $this->db->execute();

            $this->db->commit();

        } catch(\PDOException $e) {
            $this->db->rollback();
            trigger_error($e->getMessage());
        }
    }

    public function save_password_forgot_request(string $code, string $exp_date) {
        $sql_query = "INSERT INTO user_password_forgot SET password_code = :code, user_id = :id, exp_date = :date";

        $this->db->prepare($sql_query);
        $this->db->bind(':code', $code);
        $this->db->bind(':id',   $this->id);
        $this->db->bind(':date', $exp_date);
        $this->db->execute();
    }

    public function get_confirmation_details(string $code) : void {
        $sql_query = "SELECT * FROM user_confirmation WHERE confirmation_code = :code";

        $this->db->prepare($sql_query);
        $this->db->bind(':code', $code);
        $this->db->execute();

        $result_set = $this->db->single();
        
        if($result_set) {
            $this->id               = (int) $result_set['user_id'];
            $this->confirmation_id  = (int) $result_set['confirmation_id'];
            $this->confirm_exp_date = new \DateTime($result_set['expire_date']); 
        }
    }

    public function get_forgot_password_details(string $code) : void {
        $sql_query = "SELECT * FROM user_password_forgot WHERE password_code = :code";

        $this->db->prepare($sql_query);
        $this->db->bind(':code', $code);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) {
            $this->password_forgot_id       = (int) $result_set['password_forgot_id'];
            $this->password_code            = $result_set['password_code'];
            $this->id                       = (int) $result_set['user_id'];
            $this->password_forgot_exp_date = new \DateTime($result_set['exp_date']);
        }
    }

    public function check_password_forgot_id() : bool {
        $sql_query = "SELECT * FROM user_password_forgot WHERE password_forgot_id = :id AND user_id = :user_id";

        $this->db->prepare($sql_query);
        $this->db->bind(":id",      $this->password_forgot_id);
        $this->db->bind(':user_id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    // UPDATE ACCOUNT NEW CONFIRMATION CODE
    public function change_confirmation_code(string $code, string $date) : void {
        $sql_query = "UPDATE user_confirmation SET confirmation_code = :code, expire_date = :date WHERE confirmation_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':code', $code);
        $this->db->bind(':date', $date);
        $this->db->bind(':id',   $this->confirmation_id);
        $this->db->execute();
    }

    // UPDATE USER PASSWORD
    public function change_password() : void {
        $sql_query = "UPDATE users SET password = :password WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id',       $this->id);
        $this->db->bind(':password', $this->password);
        $this->db->execute();
    }

    // UPDATE LOGIN AND LOGOUT STATUS
    public function update_status(string $method, string $token = '') : void {
        if($method === 'login') {
            $sql_query = "UPDATE user_status SET is_logged = 1, logged_in = NOW(), logged_out = NULL, login_token = :token WHERE user_id = :id";

            $this->db->prepare($sql_query);
            $this->db->bind(':token', $token);
            $this->db->bind(':id',    $this->id);
            $this->db->execute();
        } else {
            $sql_query = "UPDATE user_status SET is_logged = 0, logged_in = NULL, logged_out = NOW(), remember_token = NULL, login_token = NULL WHERE user_id = :id";

            $this->db->prepare($sql_query);
            $this->db->bind(':id', $this->id);
            $this->db->execute();
        }
    }

    // UPDATE FORGOT PASSWORD CODE
    public function change_password_forgot_code(string $code, string $exp_date) : void {
        $sql_query = "UPDATE user_password_forgot SET password_code = :code, exp_date = :date WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':code', $code);
        $this->db->bind(':date', $exp_date);
        $this->db->bind(':id',   $this->id);
        $this->db->execute();
    }

    public function delete_confirmation_code() : void {
        $sql_query = "DELETE FROM user_confirmation WHERE confirmation_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->confirmation_id);
        $this->db->execute();
    }

    public function delete_password_forgot_code() : void {
        $sql_query = "DELETE FROM user_password_forgot WHERE password_forgot_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->password_forgot_id);
        $this->db->execute();
    }

    public function get_credentials() : bool {
        $sql_query = "SELECT 
                        u.user_id,
                        u.first_name,
                        u.last_name,
                        u.email,
                        u.username,
                        u.password,
                        (SELECT COUNT(*) FROM user_rating WHERE rating_user_id = u.user_id) rating,
                        (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id) posts,
                        u.is_activated,
                        u.registered_at,
                        us.logged_in,
                        pi.image_src,
                        pi.image_root
                    FROM users u
                    INNER JOIN user_status us 
                        ON u.user_id = us.user_id
                    LEFT JOIN profile_images pi 
                        ON u.image_id = pi.image_id
                    WHERE u.email = :email";

        $this->db->prepare($sql_query);
        $this->db->bind(':email', $this->email);
        $this->db->execute();

        $result = $this->db->single();

        if($result) {
            $this->id            = $result['user_id'];
            $this->first_name    = $result['first_name'];
            $this->last_name     = $result['last_name'];
            $this->email         = $result['email'];
            $this->username      = $result['username'];
            $this->password      = $result['password'];
            $this->rating        = $result['rating'];
            $this->posts         = $result['posts'];
            $this->is_activated  = $result['is_activated'];
            $this->registered_at = $result['registered_at'];
            $this->logged_in     = $result['logged_in'];
            $this->src_path      = $result['src_path'];
            $this->root_path     = $result['root_path'];

            return true;
        }

        return false;
    }

    public function activate_account() : void {
        $sql_query = "UPDATE users SET is_activated = 1 WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();
    }

    public function get_countries() : void {
        $sql_query = "SELECT country_id, name FROM countries";

        $this->db->prepare($sql_query);
        $this->db->execute();

        $result_set = $this->db->all();

        $this->countries = $result_set;
    }

    public function find_email_by_id() : string {
        $sql_query = "SELECT email FROM users WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        $this->email = $result_set['email'];

        return $result_set['email'];
    }

    public function find_id_by_email() : void {
        $sql_query = "SELECT user_id FROM users WHERE email = :email";

        $this->db->prepare($sql_query);
        $this->db->bind(':email', $this->email);
        $this->db->execute();

        $result_set = $this->db->single();

        $this->id = (int) $result_set['user_id'];
    }

    public function email_exists() : bool {
        $sql_query = "SELECT email FROM users WHERE email = :email";

        $this->db->prepare($sql_query);
        $this->db->bind(':email', $this->email);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    public function username_exists() : bool {
        $sql_query = "SELECT username FROM users WHERE username = :username";

        $this->db->prepare($sql_query);
        $this->db->bind(':username', $this->username);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    public function already_sent_password_request() : bool {
        $sql_query = "SELECT * FROM user_password_forgot WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

}