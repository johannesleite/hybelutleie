<?php
require_once(__DIR__ . '/../initialize.php');


class User extends Database {

    public $user_id;
    public $user_name;
    public $user_phone;
    public $user_email;
    public $user_password;
    public $user_check_password;
    protected $user_hashed_password;
    protected $user_password_required = true;

    // protected static $db;

    // public function __construct($args=[]) {
    //     $this->name = $args['name'] ?? '';
    //     $this->phone = $args['phone'] ?? '';
    //     $this->email = $args['email'] ?? '';
    //     $this->password = $args['password'] ?? '';
    //     $this->check_password = $args['check_password'] ?? '';
    // }

    protected function set_hashed_password() {
        $this->user_hashed_password = password_hash($this->user_password, PASSWORD_DEFAULT);
    }

    public function verify_password($user_password) {
        return password_verify($user_password, $this->user_hashed_password);
    }

    //returns user object if email exists
    public function user_email_check($user_email)
    {
        $stmt = Database::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        return $user;
    }

    //returns a boolean value if email exists
    public function user_email_exists($user_email)
    {
        $stmt = Database::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = (bool) $stmt->get_result()->fetch_row();

        return $result;
    }

    public function user_register($user_name, $user_phone, $user_email, $user_hashed_password)
    {
        $stmt = Database::$db->prepare("INSERT INTO user (user_name, user_phone, user_email, user_hashed_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user_name, $user_phone, $user_email, $user_hashed_password);
        $stmt->execute();

        $stmt->close();
    }
}
