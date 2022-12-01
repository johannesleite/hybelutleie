<?php
    require_once('../../private/initialize.php');

    $session->logout();
 
	header('location:'.url_for('/index.php'));