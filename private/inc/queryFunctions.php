<?php

require(INC_PATH . '/db.inc.php');

    function insertAd ($firstName, $lastName, $email, $phone) {
    
        $conn = new Conn();
        $dbConn = $conn->conn();
        //preparing statement, binding parameters to the form data and executing statement before closing it.
        $sql = $dbConn->prepare("INSERT INTO user (ad_image, ad_title, ad_residence_type, ad_desc, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $firstName, $lastName, $email, $phone);
        $sql->execute();
        
        $sql->close();
    }

    function checkForExistingEmail ($email) {
        $conn = new Conn();
    $dbConn = $conn->conn();
    $stmt = $dbConn->prepare("SELECT * FROM user WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();
    $emailCheck = "";
    $stmt->bind_result($emailCheck);
    $stmt->fetch();
    if ($stmt->num_rows() == 1) {
        $errorArr["email"] = "En bruker med denne eposten eksisterer allerede";
    }
    }

