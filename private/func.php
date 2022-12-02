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
    function display_error_messages($errorArr) {
        $error_text = '
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-danger" role="alert">Vennligst rett opp feilene under og prøv på nytt</p>';
                foreach ($errorArr as $value) {
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

    //validate input from form ad
    function validate_ad_input($ad_title, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip) {
        if (isset($_POST["submit"])) {
            $error_arr = array();

            if (empty($ad_title))
                $error_arr[] = "Tittel er påkrevd";

            if (empty($ad_residence_type)) 
                $error_arr[] = "Velg boligtype";

            if (empty($ad_desc)) 
                $error_arr[] = "Beskrivelse er påkrevd";

            if (empty($ad_size))
                $error_arr[] = "Størrelse i kvm er påkrevd";
            else if (!is_numeric($ad_size))
                $error_arr[] = "Størrelse i kvm må være i tall";

            if (empty($ad_price)) 
                $error_arr[] = "Pris er påkrevd";
            else if (!is_numeric($ad_price)) 
                $error_arr[] = "Pris må være i tall";  

            if (empty($ad_street_address))
                $error_arr[] = "Adresse er påkrevd";   

            if (empty($ad_zip))
                $error_arr[] = "Postnummer er påkrevd";
            else if (strlen($ad_zip != 4 && !is_numeric($ad_zip)))
                $error_arr[] = "Postnummer må være fire tall";
        
            return $error_arr;
        }
    }

    function validate_img() {
        if (isset($_POST['submit'])) {        
            $img_error_arr = array();
            //file info
            $file_type = $_FILES['image']['type'];
            $file_size = $_FILES['image']['size'];

            //configurations
            $accepted_file_types = array("jpg" => "image/jpeg",
                                         "png" => "image/png");
            $max_file_size = 1024*1024*8; //8 MB
            
            if (!empty($file_type) && !in_array($file_type, $accepted_file_types)) {
                $types = implode(", ", array_keys($accepted_file_types));
                $img_error_arr[] = "Ugyldig filformat (Kun $types er tillatt)";
            }

            if ($file_size > $max_file_size)
                $img_error_arr[] = "Filstørrelsen (" . round($file_size / 1048576, 2) . " MB) er større enn tillatt (" . round($max_file_size / 1048576, 2) . " MB)"; // Bin. conversion
            
            return $img_error_arr;
        }
    }
        
?>