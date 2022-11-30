<?php
    require_once('../../private/initialize.php');

    $session->logout();
 
	header('location:'.PUBLIC_PATH .'/index.php');