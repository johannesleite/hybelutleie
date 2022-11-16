<?php
require_once(__DIR__ . "/../initialize.php");

class Session {

    private $user_id;
    public $user_email;
    public $user_first_name;

    public function __construct()
    {
    session_start();
    $this->checkStoredLogin();
    }

    public function login($user) {
        if ($user) {
            $this->user_id = $_SESSION["user_id"] = $user->id;
            $this->user_email = $_SESSION["user_email"] = $user->email;
            $this->user_first_name = $_SESSION["user_first_name"] = $user->first_name;
        }
        return true;
    }

    public function isLoggedIn() {
        // return isset($this->user_id);
        return isset($this->user_id);
    }

    public function logout() {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_first_name"]);
        unset($this->user_id);
        unset($this->user_email);
        unset($this->user_first_name);
        return true;
    }

    private function checkStoredLogin() {
        if (isset($_SESSION["user_id"])) {
            $this->user_id = $_SESSION["user_id"];
            $this->user_email = $_SESSION["user_email"];
            $this->user_first_name = $_SESSION["user_first_name"];
        }
    }
}