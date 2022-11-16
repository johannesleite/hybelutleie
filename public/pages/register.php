<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--login form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <h3>Registrere ny bruker</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-outline mb-1">
                <label class="form-label" for="firstName">Fornavn</label>
                <input type="text" name="firstName" id="firstName" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="lastName">Etternavn</label>
                <input type="text" name="lastName" id="lastName" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="phone">Telefonnummer</label>
                <input type="text" name="phone" id="phone" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="password">Passord (Minst 8 tegn)</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="checkPassword">Gjenta passord</label>
                <input type="password" name="checkPassword" id="checkPassword" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Registrer</button>
        </form>
    </div>
</div>

<?php
$errorArr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    $firstName = $lastName = $phone = $email = $password = $checkPassword = "";

    //validation of input
    if (empty($_POST["firstName"])) {
        $errorArr["firstName"] = "Fornavn er påkrevd";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["firstName"])) {
        $errorArr["firstName"] = "Fornavn kan kun inneholde bokstaver";
    } else {
        $firstName = test_input($_POST["firstName"]);
    }

    if (empty($_POST["lastName"])) {
        $errorArr["lastName"] = "Etternavn er påkrevd";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lastName"])) {
        $errorArr["lastName"] = "Etternavn kan kun inneholde bokstaver";
    } else {
        $lastName = test_input($_POST["lastName"]);
    }

    if (empty($_POST["phone"])) {
        $errorArr["phone"] = "Telefonnummer er påkrevd";
    } else if (!is_numeric($_POST["phone"])) {
        $errorArr["phone"] = "Telefonnummer kan bare inneholde tall";
    } else {
        $phone = test_input($_POST["phone"]);
    }

    if (empty($_POST["email"])) {
        $errorArr["email"] = "Epostadresse er påkrevd";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorArr["email"] = "Epostadressen har ugyldig format";
    } else {
        $email = test_input($_POST["email"]);
    }

    
    $user = new User;

    $exists = $user->userEmailExists($email);

    if ($exists) {
        $errorArr["email"] = "En bruker med denne eposten eksisterer allerede";
    }

    if (empty($_POST["password"]) && empty($_POST["checkPassword"])) {
        $errorArr["password"] = "Passord er påkrevd";
    } else if ($_POST["password"] != $_POST["checkPassword"]) {
        $errorArr["password"] = "Passord og gjentatt passord er ikke like";
    } else if (strlen($_POST["password"] < 8)) {
        $errorArr["password"] = "Passordet må inneholde minst 8 tegn";
    } else
        $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

    //printing of content and inserting into db
    if (empty($errorArr)) {

        $user->userRegister($firstName, $lastName, $phone, $email, $hashedPassword);
?>

        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p><strong>Din brukerprofil har blitt opprettet, du blir videresendt til innloggingssiden!</strong></p>
                <?php header("Refresh:5; url=" . urlFor('/pages/login.php')); ?>
            </div>
        </div>

    <?php
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
