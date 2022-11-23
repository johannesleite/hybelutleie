<?php
class Database {

    static protected $database;
    static protected $table_name = "";
    static protected $columns = [];
    public $errors = [];

    static public function set_database($database) {
        self::$database = $database;
    }

    

}