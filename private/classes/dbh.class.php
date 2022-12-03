<?php
//database handler
class Dbh {

    protected function connect() {
        try {
            $username = 'root';
            $password = '';
            $dbh = new PDO('mysql:host=localhost;dbname=hybelprosjektutkast', $username, $password);
            return $dbh;
        }
        //if cannot connect: grab error message and kill connection
        catch (PDOException $e){
            print "Error!: ". $e->getMessage() . "<br/>";
            die();
        }
    }
}