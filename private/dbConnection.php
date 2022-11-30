<?php

function connection ()
{
    $servername = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'hybelprosjektutkast';

    $conn = new mysqli($servername, $user, $password, $db);

    if ($conn->connect_errno) {
        echo "failed to connect to MySQL: " . $conn->connect_error;
    } else
    return $conn;
}