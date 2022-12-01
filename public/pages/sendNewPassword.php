<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--forgotten password form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <h3>Skriv inn din epostadresse for å få tilsendt nytt passord</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-outline mb-3">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Send nytt passord</button>
        </form>
    </div>
</div>


<?php

if (isset($_POST["submit"])) {

$email = "";

//validation of input
if (empty($_POST["email"])) {
    $errorArr["email"] = "Epostadresse er påkrevd";
} else {
    $email = test_input($_POST["email"]);
}

if (empty($errorArr)) {

$to_email = "$email";
$subject = "Glemt passord hos Hybelutleie AS";
$body = "Ditt passord har blitt endret til $randomPassword";
$headers = "From: sender\'s email";
 
if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}

/*
    Finne epost i system.

        $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!empty($user)) {
            $randomPassword = generatePassword();
            //generatePassword() må returnere passord i klartekst
            //så hashe passord og oppdatere dette inn i brukers kolonne i DB
            $stmt = User::$db->prepare("UPDATE user SET user_hashed_password=? WHERE email=?");
            $stmt->bind_param("ss", $randomHashedPassword, $user[user_email]);
            $stmt->execute();

            $stmt->close();

        }

*/
    }
}