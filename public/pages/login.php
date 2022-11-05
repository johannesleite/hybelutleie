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
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $errorArr["password"] = "Passord er påkrevd";
    } else {
        $password = $_POST["password"];
    }

    if (empty($errorArr)) {

        // $Dbconn = new Database();
        // $conn = $Dbconn->connect();
        $conn = new Database();
        $dbConn = $conn->connection();

        $stmt = $dbConn->prepare("SELECT * FROM user WHERE user_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        // $result = $stmt->bind_result();
        // $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['user_password'])) {
            $_SESSION['user_auth'] = "auth";
            $_SESSION['user_id'] = $user['user_firstname'];
?>
            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p><strong>Innlogging vellykket, du blir videresendt til hjemmesiden</strong></p>
                    <?php header("Refresh:5; url=" . urlFor('/pages/index.php')); ?>
                </div>
            </div>
        <?php

        } else {
            //failed
        }
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
