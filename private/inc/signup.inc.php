<?php

if (isset($_POST["submit"])) {
    //grabbing the data from signup.php
    $user_name = ($_POST["user_name"]);
    $user_phone = ($_POST["user_phone"]);
    $user_email = ($_POST["user_email"]);
    $user_password = ($_POST["user_password"]);
    $user_check_password = ($_POST["user_check_password"]);

    //instantiate SignupContr class
    include "../classes/dbh.class.php";
    include "../classes/signup.class.php";
    include "../classes/signup-contr.class.php";
    $signup = new SignupContr($user_name, $user_phone, $user_email, $user_password, $user_check_password);
    //running error handlers and user signup
    $signup->signup_user();
    //going back to the front page
    header("Location: ../../public/index.php?error=none"); exit();
}

