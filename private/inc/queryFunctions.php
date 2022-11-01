<?php
require_once('../initialize.php');
require_once(INC_PATH . '/db.inc.php');

function insertAd($conn, $firstName, $lastName, $email, $phone)
{
    //preparing statement, binding parameters to the form data and executing statement before closing it.
    $sql = $conn->prepare("INSERT INTO user (ad_image, ad_title, ad_residence_type, ad_desc, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $firstName, $lastName, $email, $phone);
    $sql->execute();

    $sql->close();
}

function checkForExistingEmail($conn, $email)
{
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_email=?");
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