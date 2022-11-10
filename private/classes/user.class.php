<?php
require_once(__DIR__ . '/../initialize.php');


class User {

    public static $db;

    public static function set_database($db) {
       self::$db = $db;
   }

   function userLogin ($email) {

        $stmt = User::$db->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->bind_result();

        return $result;
   }

   function userEmailExists ($email) {

    $stmt = User::$db->prepare("SELECT * FROM user WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->bind_result();

    return $result;
}

}