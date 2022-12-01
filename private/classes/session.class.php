<?php
require_once(__DIR__ . "/../initialize.php");

class Session {

    public $user_id;
    public $user_email;
    public $user_name;

    public function __construct()
    {
    session_start();
    $this->check_stored_login();
    }

    public function login($user) {
        if ($user) {
            $this->user_id = $_SESSION["user_id"] = $user->user_id;
            $this->user_email = $_SESSION["user_email"] = $user->user_email;
            $this->user_name = $_SESSION["user_name"] = $user->user_name;
        }
        return true;
    }

    public function is_logged_in() {
        return isset($this->user_id);
    }

    public function logout() {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_name"]);
        unset($this->user_id);
        unset($this->user_email);
        unset($this->user_name);
        return true;
    }

    private function check_stored_login() {
        if (isset($_SESSION["user_id"])) {
            $this->user_id = $_SESSION["user_id"];
            $this->user_email = $_SESSION["user_email"];
            $this->user_name = $_SESSION["user_name"];
        }
    }
}