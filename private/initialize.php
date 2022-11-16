<?php
    // Assign file paths to PHP constants
    // __FILE__ returns the current path to this file
    // dirname() returns the path to the parent directory
    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("INC_PATH", PRIVATE_PATH . '/inc');

    // Assign the root URL to a PHP constant
    // * Do not need to include the domain
    // * Use same document root as webserver
    // * Can dynamically find everything in URL up to "/public"
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);

    require_once('func.php');
    require_once('dbConnection.php');

    foreach (glob('classes/*.class.php') as $file) {
        require_once($file);
    }

    function my_autoload($class) {
        if(preg_match('/\A\w+\Z/', $class)) {
          include('classes/' . $class . '.class.php');
        }
      }
      spl_autoload_register('my_autoload');

    $db = connection();
    Advert::set_database($db);
    User::set_database($db);

    $session = new Session;

?>