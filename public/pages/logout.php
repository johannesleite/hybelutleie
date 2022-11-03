<?php
    require_once('../../private/initialize.php');
    require(INC_PATH . '/db.inc.php');

	session_destroy();
 
	header('location:'.PUBLIC_PATH .'/index.php');