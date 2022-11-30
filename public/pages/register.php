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
                <label class="form-label" for="name">Fullt navn</label>
                <input type="text" name="name" id="name" class="form-control" />
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
                <label class="form-label" for="check_password">Gjenta passord</label>
                <input type="password" name="check_password" id="check_password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Registrer</button>
        </form>
    </div>
</div>

<?php
$errorArr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

   $name = test_input($_POST['name']) ?? '';
   $phone = test_input($_POST["phone"]) ?? '';
   $email = test_input($_POST["email"]) ?? '';
   $password = test_input($_POST["password"]) ?? '';
   $check_password = test_input($_POST["check_password"]) ?? '';

    //validation of input
    if (empty($name)) {
        $errorArr[] = "Navn er påkrevd";
    } else if (!preg_match("/^[a-zA-ZæÆøØåÅéÉ' -]*$/", $name)) {
        $errorArr[] = "Navn kan kun inneholde norske bokstaver og mellomrom";
    }
    // else {
    //     $name = test_input($_POST["name"]);
    // }

    if (empty($phone)) {
        $errorArr[] = "Telefonnummer er påkrevd";
    } else if (!is_numeric($_POST["phone"])) {
        $errorArr[] = "Telefonnummer kan bare inneholde tall";
    }
    //  else {
    //     $phone = test_input($_POST["phone"]);
    // }

    if (empty($email)) {
        $errorArr[] = "Epostadresse er påkrevd";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorArr[] = "Epostadressen har ugyldig format";
    } 
    // else {
    //     $email = test_input($_POST["email"]);
    // }
    
    //creates a new user object
    $user = new User;

    $exists = $user->user_email_exists($email);

    if ($exists) {
        $errorArr[] = "En bruker med denne eposten eksisterer allerede";
    }

    if (empty($password) || empty($check_password)) {
        $errorArr[] = "Passord er påkrevd";
    } else if ( $password != $check_password) {
        $errorArr[] = "Passord og gjentatt passord er ikke like";
    } else if (!preg_match("/^(?=.*[A-ZÆØÅÉ])(?=.*[a-zæøåé])(?=.*\d).{8,}$/", $password) ) {
        $errorArr[] = "Passordet må være minst 8 tegn og ha minst én stor bokstav, én liten bokstav og ett tall";
    } else
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //printing of content and inserting into db
    if (empty($errorArr)) {

        $user->user_register($name, $phone, $email, $hashed_password);
    ?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-success" role="alert">Din brukerprofil har blitt opprettet, du blir videresendt til innloggingssiden!</p>
                
            </div>
            <?php header("Refresh:3; url=" . url_for('/pages/login.php')); exit(); ?>
        </div>
    <?php
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
