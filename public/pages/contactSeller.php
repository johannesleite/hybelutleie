<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--contact form-->

<div class="container d-flex align-items-center my-5">
    <div class="col-md-6 py-4 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-outline mb-3">
                <label class="form-label" for="from_email">Din epostadresse</label>
                <input type="email" name="from_email" id="from_email" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="subject">Tittel</label>
                <input type="text" name="subject" id="subject" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="message">Beskrivelse</label>
                <textarea class="form-control" name="message" id="message" rows="8" placeholder="Legg til beskrivelse her"></textarea>
            </div>
            <input type="hidden" name="to_email" value="<?php echo $_POST["to_email"] ?>">
            <input type="hidden" name="ad_title" value="<?php echo $_POST["ad_title"] ?>">
            <button type="submit" name="submit" class="btn btn-primary">Send melding</button>
        </form>
    </div>
</div>

<?php

if (isset($_POST["submit"])) {

    $error_arr = [];

    $from_email = $_POST["from_email"] ?? '';
    $subject = $_POST["subject"] ?? '';
    $message = $_POST["message"] ?? '';
    $to_email = $_POST["to_email"] ?? '';
    $ad_title = $_POST["ad_title"] ?? '';


    //validation of input
    if (empty($from_email))
        $error_arr[] = "Epostadresse er påkrevd";

    if (empty($subject))
        $error_arr[] = "Tittel er påkrevd";

    if (empty($message))
        $error_arr[] = "Beskrivelse er påkrevd";

    if (empty($error_arr)) {

        $headers = "From: Hybelutleie AS";
        $message .= "\n\n Annonsen det gjelder: $ad_title.";
        $message .= "\nSendt fra: $from_email";

        if (mail($to_email, $subject, $message, $headers))
            display_success_message("Epost sendt til $to_email!");
        else {
            $error_arr[] = "Sending av melding feilet... Vennligst prøv på nytt";
            display_error_messages($error_arr);
        }
    }
    else
        display_error_messages($error_arr);

}
