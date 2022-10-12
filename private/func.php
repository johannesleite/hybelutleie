<?php

    //function to get absolute root
    function urlFor($script_path) {
    if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
    }

?>