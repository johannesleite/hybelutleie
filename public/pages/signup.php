<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--login form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <h3>Registrere ny bruker</h3>
        <form action="../../private/inc/signup.inc.php" method="POST">
            <div class="form-outline mb-1">
                <label class="form-label" for="name">Fullt navn</label>
                <input type="text" name="user_name" id="name" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="phone">Telefonnummer</label>
                <input type="text" name="user_phone" id="phone" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="user_email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="password">Passord (Minst 8 tegn)</label>
                <input type="password" name="user_password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-2">
                <label class="form-label" for="check_password">Gjenta passord</label>
                <input type="password" name="user_check_password" id="check_password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Registrer</button>
        </form>
    </div>
</div>

<?php
include(INC_PATH . '/footer.php');
?>
