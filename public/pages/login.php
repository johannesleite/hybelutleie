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
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="password">Passord</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
</div>

<?php

$errorArr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    $email = $password = "";

    //validation of input
    if (empty($_POST["email"])) {
        $errorArr[] = "Epostadresse er påkrevd";
    } else {
        $email = test_input($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $errorArr[] = "Passord er påkrevd";
    } else {
        $password = $_POST["password"];
    }

    if (empty($errorArr)) {

        $user = new User();
        
        $userResult = $user->user_login($email);
var_dump($userResult);
echo "<br>$userResult->user_hashed_password<br>";
echo password_verify($password, $userResult->user_hashed_password);
        if ($userResult != false && password_verify($password, $userResult->user_hashed_password)) {
            $session->login($userResult);
        ?>

            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p><strong>Innlogging vellykket, du blir videresendt til hjemmesiden</strong></p>
                    <?php header("url=" . urlFor('/index.php')); ?>
                </div>
            </div>

        <?php

        } else {
            //failed
            ?>
            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p><strong>epostadresse og/eller passord er feil, vennligst prøv på nytt.</strong></p>
                    <?php // header("Refresh:5; url=" . urlFor('/index.php')); ?>
                </div>
            </div>
    <?php }
    } else {

        ?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p style="color: red; font-weight: bold;">Vennlist rett opp feilene under og prøv på nytt</p>
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
