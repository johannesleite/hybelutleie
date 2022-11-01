<?php
require_once('../../private/paths.php');
require(INC_PATH . '/db.inc.php');
include(INC_PATH . '/header.php');
?>

<!--login form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-outline mb-1">
                <label class="form-label" for="firstName">Fornavn</label>
                <input type="text" name="phone" id="phone" class="form-control" />
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
        $errorArr["firstName"] = "First name: Only letters and whitespace allowed";
    } else
        $firstName = $_POST["firstName"];

    if (empty($_POST["lastName"])) {
        $errorArr["lastName"] = "Etternavn er påkrevd";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lastName"])) {
        $errorArr["lastName"] = "Last name: Only letters and whitespace allowed";
    } else
        $lastName = $_POST["lastName"];

    if (empty($_POST["phone"])) {
        $errorArr["phone"] = "Telefonnummer er påkrevd";
    } else if (!is_numeric($_POST["phone"])) {
        $errorArr["phone"] = "Phone number must contain numbers only";
    } else
        $phone = $_POST["phone"];

    if (empty($_POST["email"])) {
        $errorArr["email"] = "Epostadresse er påkrevd";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorArr["email"] = "Invalid email format";
    } else
        $email = $_POST["email"];

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

        //preparing statement, binding parameters to the form data and executing statement before closing it.
        $sql = $conn->prepare("INSERT INTO user (user_firstname, user_lastname, user_phone, user_email, user_password) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $firstName, $lastName, $phone, $email, $hashedPassword);
        $sql->execute();

        $sql->close();
        $conn->close();

        echo "<h2>Din brukerprofil har blitt opprettet, du blir videresendt til innloggingssiden!</h2>";
        header("refresh:5; Location: " . urlFor('/pages/login.php'));
        exit();
    } else {

?>

        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p style="color: red; font-weight: bold;">Se feilmeldinger under</p>
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
