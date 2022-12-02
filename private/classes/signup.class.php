<?php
//database related stuff here, e.g. run query
class Signup extends Dbh {
    
    //has to be protected because we refer to the signup-contr class
    protected function check_user($user_email){
        //prepared statement, connect to db, send query
        $stmt = $this->connect()->prepare('SELECT user_name FROM user WHERE user_email = ?;'); 
    
        //true or false statement
        if (!$stmt->execute(array($user_email))) {
            //if statement fails, set $stmt to null and send to index.php
            $stmt = null;
            header("Location: ../../public/index.php?error=stmtfailed"); exit();
        }
        
        //check if user exists in database already
        if ($stmt->rowCount() > 0) {
            $result_check = false;
        }
        else {
            $result_check = true;
        }

        return $result_check;
    }

    /* Set user into database */
    protected function set_user($user_name, $user_phone, $user_email, $user_password){
        
        $stmt = $this->connect()->prepare('INSERT INTO user (user_name, user_phone, user_email, 
        user_hashed_password) VALUES (?, ?, ?, ?)'); 
    
        $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($user_name, $user_phone, $user_email, $user_hashed_password))) {
            $stmt = null;
            header("Location: ../../public/index.php?error=stmtfailed"); exit();
        }
        
        $stmt = null; 
    }
}
?>