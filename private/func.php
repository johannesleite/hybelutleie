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

    function require_login() {
        global $session;
        if(!$session->is_logged_in()) {
            header('location:'.url_for('/index.php'));
        } 
        // else {
        //   // Do nothing, let the rest of the page proceed
        // }
    }
?>