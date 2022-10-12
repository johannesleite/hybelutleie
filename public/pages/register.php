<?php
require_once('../../private/paths.php');
include(INC_PATH . '/header.php');
?>

<!--login form-->

<div class="container h-100 d-flex align-items-center">
    <div class="col-md-4 py-3 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST">
            <div class="form-outline mb-1">
                <label class="form-label" for="email">Epostadresse</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-1">
                <label class="form-label" for="password">Passord</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
</div>

<?php include(INC_PATH . '/footer.php'); ?>