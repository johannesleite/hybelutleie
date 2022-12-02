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
                <input type="text" name="user_name" id="name" class="form-control" value="<?php echo $user->user_name; ?>"/>
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="phone">Telefonnummer</label>
                <input type="text" name="user_phone" id="phone" class="form-control" value="<?php echo $user->user_phone; ?>" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="user_email" id="email" class="form-control" value="<?php echo $user->user_email; ?>" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="password">Gammelt passord</label>
                <input type="password" name="user_password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="password">Nytt passord (Minst 8 tegn)</label>
                <input type="password" name="user_password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="check_password">Gjenta nytt passord</label>
                <input type="password" name="user_check_password" id="check_password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Registrer</button>
        </form>
    </div>
</div>

<?php
$errorArr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    $user_name = test_input($_POST["user_name"]) ?? '';
    $user_phone = test_input($_POST["user_phone"]) ?? '';
    $user_email = test_input($_POST["user_email"]) ?? '';
    $user_password = test_input($_POST["user_password"]) ?? '';
    $user_check_password = test_input($_POST["user_check_password"]) ?? '';
 
    //validation of input
    if (empty($user_name)) {
        $errorArr[] = "Navn er påkrevd";
    } else if (!preg_match("/^[a-zA-ZæÆøØåÅéÉ' -]*$/", $user_name)) {
        $errorArr[] = "Navn kan kun inneholde norske bokstaver og mellomrom";
    }

    if (empty($user_phone)) {
        $errorArr[] = "Telefonnummer er påkrevd";
    } else if (!is_numeric($user_phone)) {
        $errorArr[] = "Telefonnummer kan bare inneholde tall";
    }

    if (empty($user_email)) {
        $errorArr[] = "Epostadresse er påkrevd";
    } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errorArr[] = "Epostadressen har ugyldig format";
    } 
    
    //creates a new user object
    $user = new User;

    $exists = $user->user_email_exists($user_email);

    if ($exists) {
        $errorArr[] = "En bruker med denne eposten eksisterer allerede";
    }

    if (empty($user_password) || empty($user_check_password)) {
        $errorArr[] = "Passord er påkrevd";
    } else if ( $user_password != $user_check_password) {
        $errorArr[] = "Passord og gjentatt passord er ikke like";
    } else if (!preg_match("/^(?=.*[A-ZÆØÅÉ])(?=.*[a-zæøåé])(?=.*\d).{8,}$/", $user_password) ) {
        $errorArr[] = "Passordet må være minst 8 tegn og ha minst én stor bokstav, én liten bokstav og ett tall";
    } else
        $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    //printing of content and inserting into db
    if (empty($errorArr)) {

        $user->user_register($user_name, $user_phone, $user_email, $user_hashed_password);
    ?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-success" role="alert">Din brukerprofil har blitt opprettet, du blir videresendt til innloggingssiden!</p>
                
            </div>
            <?php header("Refresh:3; url=" . url_for('/pages/login.php')); exit(); ?>
        </div>
    <?php
    } else {
        display_error_messages($errorArr);
    }
 }
 
 include(INC_PATH . '/footer.php');
 