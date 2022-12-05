<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');

$error_arr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    $user_email = test_input($_POST["user_email"]) ?? '';
    $user_password = test_input($_POST["user_password"]) ?? '';


    //validation of input
    if (empty($_POST["user_email"]))
        $error_arr[] = "Epostadresse er påkrevd";

    if (empty($_POST["user_password"]))
        $error_arr[] = "Passord er påkrevd";

    if (empty($error_arr)) {

        $user = new User();

        //check if email exists in database
        $user_result = $user->user_email_check($user_email);

        if ($user_result && password_verify($user_password, $user_result->user_hashed_password)) {
            $session->login($user_result);

            display_loading_symbol();
            header("Refresh:1; url=" . url_for('/index.php')); exit();
        } else {
            $error_arr[] = "epostadresse og/eller passord er feil, vennligst prøv på nytt.";
            display_error_messages($error_arr);
        }
    } else
        display_error_messages($error_arr);
}

?>

<!--login form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <h3>Logg inn på din bruker</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-outline mb-3">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="user_email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="password">Passord</label>
                <input type="password" name="user_password" id="password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
</div>

<?php

include(INC_PATH . '/footer.php');
