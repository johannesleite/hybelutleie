<?php

class Conn
{
    function conn()
    {
        $user = 'root';
        $password = '12345';
        $db = 'hybelprosjektutkast';

        $conn = new mysqli('localhost', $user, $password, $db) or die("unable to connect");

        return $conn;
    }
}
