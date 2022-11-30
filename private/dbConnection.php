<?php

function connection ()
{
<<<<<<< HEAD
    $servername = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'hybelprosjektutkast';

    $conn = new mysqli($servername, $user, $password, $db);
=======
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
>>>>>>> b49892324457479b25101be6149ebd68478668d4

    if ($conn->connect_errno) {
        echo "failed to connect to MySQL: " . $conn->connect_error;
    } else
    return $conn;
}