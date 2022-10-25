<?php

require(INC_PATH . '/db.inc.php');

    function InsertAd ($firstName, $lastName, $email, $phone) {
    
        $conn = new Conn();
        $dbConn = $conn->conn();
        //preparing statement, binding parameters to the form data and executing statement before closing it.
        $sql = $dbConn->prepare("INSERT INTO user (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $firstName, $lastName, $email, $phone);
        $sql->execute();
        
        $sql->close();

    }

