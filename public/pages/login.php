<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
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

$errorArr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    $user_email = test_input($_POST["user_email"]) ?? '';
    $user_password = test_input($_POST["user_password"]) ?? '';


    //validation of input
    if (empty($_POST["user_email"])) {
        $errorArr[] = "Epostadresse er påkrevd";
    } 

    if (empty($_POST["user_password"])) {
        $errorArr[] = "Passord er påkrevd";
    }

    if (empty($errorArr)) {

        $user = new User();

        //check if pa
        $userResult = $user->user_email_check($user_email);

        if ($userResult && password_verify($user_password, $userResult->user_hashed_password)) {
            $session->login($userResult);
?>

                <div class="position-absolute top-50 start-50 translate-middle">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <?php header("Refresh:2; url=" . url_for('/index.php')); exit(); ?>
                </div>
        <?php

        } else {
            //failed
        ?>
            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p class="alert alert-danger" role="alert">epostadresse og/eller passord er feil, vennligst prøv på nytt.</p>
                </div>
            </div>
        <?php }
    } else {

        ?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-danger" role="alert">Vennligst rett opp feilene under og prøv på nytt</p>
                <ul>
                    <?php foreach ($errorArr as $value) { ?>
                        <li><?php echo $value ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
<?php
    }
}

include(INC_PATH . '/footer.php');
