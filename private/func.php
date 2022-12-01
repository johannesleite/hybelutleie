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

    //for pages that requires a user to be logged in
    function show_error_messages($errorArr) {

        $error_text = '
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-danger" role="alert">Vennligst rett opp feilene under og prøv på nytt</p>
                <ul>';
                foreach ($errorArr as $value) {
                    $error_text .= '<li>'. $value . '</li>';
                }
                $error_text .= '
                </ul>
            </div>
        </div>';

        echo $error_text;
    }

    function show_success_message($success_msg) {
        echo 
        '<div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-success" role="alert">'. $success_msg. '</p>
            </div>
        </div>';
    }


?>