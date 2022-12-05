<?php
require_once(__DIR__ . '/../initialize.php');


class User extends Database {

    //returns user object if email exists
    public function user_email_check($user_email)
    {
        $sql = "SELECT * FROM user WHERE user_email=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        return $user;
    }

    //returns a boolean value if email exists
    public function user_email_exists($user_email)
    {
        $sql = "SELECT * FROM user WHERE user_email=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = (bool) $stmt->get_result()->fetch_row();

        return $result;
    }

    //register as new user
    public function user_register($user_name, $user_phone, $user_email, $user_hashed_password)
    {
        $sql = "INSERT INTO user (user_name, user_phone, user_email, user_hashed_password) VALUES (?, ?, ?, ?)";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssss", $user_name, $user_phone, $user_email, $user_hashed_password);
        $stmt->execute();
        $stmt->close();
    }

    //update own user information
    public function user_update($user_name, $user_phone, $user_email, $user_id)
    {
        $sql = "UPDATE user SET user_name=?, user_phone=?, user_email=? WHERE user_id=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssss", $user_name, $user_phone, $user_email, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //update own user information including password
    public function user_update_with_password($user_name, $user_phone, $user_email, $user_hashed_password = null, $user_id)
    {
        $sql = "UPDATE user SET user_name=?, user_phone=?, user_email=?, user_hashed_password=? WHERE user_id=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("sssss", $user_name, $user_phone, $user_email, $user_hashed_password, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //get user object
    public function user_by_id($user_id)
    {
        $sql = "SELECT * FROM user WHERE user_id=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        return $user;
    }

}
