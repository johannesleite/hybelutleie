<?php
require_once(__DIR__ . '/../initialize.php');


class User extends Database {

    public $id;
    public $name;
    public $phone;
    public $email;
    public $password;
    public $check_password;
    protected $hashed_password;
    protected $password_required = true;

    // protected static $db;

    // public function __construct($args=[]) {
    //     $this->name = $args['name'] ?? '';
    //     $this->phone = $args['phone'] ?? '';
    //     $this->email = $args['email'] ?? '';
    //     $this->password = $args['password'] ?? '';
    //     $this->check_password = $args['check_password'] ?? '';
    // }

    protected function set_hashed_password() {
        $this->hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function verify_password($password) {
        return password_verify($password, $this->hashed_password);
    }

    // public static function set_database($db)
    // {
    //     self::$db = $db;
    // }

    public function user_login($email)
    {

        $stmt = Database::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        return $user;
    }

    public function user_email_exists($email)
    {
        $stmt = Database::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = (bool) $stmt->get_result()->fetch_row();

        return $result;
    }

    public function user_register($name, $phone, $email, $hashedPassword)
    {
        $stmt = Database::$db->prepare("INSERT INTO user (user_name, user_phone, user_email, user_hashed_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $hashedPassword);
        $stmt->execute();

        $stmt->close();

    }
}
