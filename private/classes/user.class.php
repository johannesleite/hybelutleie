<?php
require_once(__DIR__ . '/../initialize.php');


class User
{

    public static $db;

    public static function set_database($db)
    {
        self::$db = $db;
    }

    function userLogin($email)
    {

        $stmt = User::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        return $user;
    }

    function userEmailExists($email)
    {
        $stmt = User::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = (bool) $stmt->get_result()->fetch_row();

        return $result;
    }

    function userRegister($firstName, $lastName, $phone, $email, $hashedPassword)
    {
        $stmt = User::$db->prepare("INSERT INTO user (user_firstname, user_lastname, user_phone, user_email, user_password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $phone, $email, $hashedPassword);
        $stmt->execute();

        $stmt->close();

    }
}
