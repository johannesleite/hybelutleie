<?php

require(INC_PATH . '/db.inc.php');

    function InsertAd ($firstName, $lastName, $email, $phone) {
    
        $conn = new Conn();
        $dbConn = $conn->conn();
        //preparing statement, binding parameters to the form data and executing statement before closing it.
        $sql = $dbConn->prepare("INSERT INTO user (ad_image, ad_title, ad_residence_type, ad_desc, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $firstName, $lastName, $email, $phone);
        $sql->execute();
        
        $sql->close();

    }

