<?php

    //function to get absolute root
    function url_for($script_path) {
    if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
    }

    //clean input data from forms
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    //insert iframe with address map in ad
    function api_address_map ($streetAddr, $ad_zip) {      
        $streetAddr = preg_replace('/\s+/', '+', $streetAddr);
    
        $apiAddr = "$streetAddr,+$ad_zip";
    
        $showMap = '
        <iframe
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key='.API_KEY.'&q='.$apiAddr.'"
            allowfullscreen>
        </iframe>
        ';
    
        echo $showMap;
    }

    //for pages that requires a user to be logged in
    function require_login() {
        global $session;
        if(!$session->is_logged_in()) {
            header('location:'.url_for('/index.php'));
        } 
    }

    //output error messages
    function display_error_messages($error_arr) {
        $error_text = '
            <div class="container d-flex align-items-center">
                <div class="col-md-4 py-3 mx-auto">
                    <p class="alert alert-danger" role="alert">Vennligst rett opp feilene under og prøv på nytt</p>';
                    foreach ($error_arr as $value) {
                        $error_text .= '<li>'. $value . '</li>';
                    }
                    $error_text .= '
                </div>
            </div>';

        echo $error_text;
    }

    //output message in green box
    function display_success_message($message) {
        echo 
        '<div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-success" role="alert">'. $message. '</p>
            </div>
        </div>';
    }

    function display_loading_symbol() {
        echo
        '<div class="position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>';
    }

?>