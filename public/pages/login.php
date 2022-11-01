<?php
require_once('../../private/initialize.php');
require(INC_PATH . '/db.inc.php');
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
        $errorArr["email"] = "Epostadresse er påkrevd";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorArr["email"] = "Epostadressen har ugyldig format";
    } else {
        $email = $_POST["email"];
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $exists = (bool) $stmt->get_result()->fetch_row();
    if ($exists) {
        $errorArr["email"] = "En bruker med denne eposten eksisterer allerede";
    }

    if (empty($_POST["password"])) {
        $errorArr["password"] = "Passord er påkrevd";

        //printing of content and inserting into db
        if (empty($errorArr)) {

            //preparing statement, binding parameters to the form data and executing statement before closing it.
            $stmt = $conn->prepare("INSERT INTO user (user_firstname, user_lastname, user_phone, user_email, user_password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $phone, $email, $hashedPassword);
            $stmt->execute();

            $stmt->close();
            $conn->close();
?>

            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p><strong>Innlogging vellykket, du blir videresendt til hjemmesiden</strong></p>
                    <?php header("Refresh:5; url=" . urlFor('/pages/index.php')); ?>
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
}
?>

<?php include(INC_PATH . '/footer.php'); ?>