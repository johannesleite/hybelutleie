<?php
require_once(__DIR__ . "/../initialize.php");

class Database {

    static protected $db;

    static public function set_database($db) {
        self::$db = $db;
    }
}