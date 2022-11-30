<?php

function connection ()
{
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_errno) {
        echo "failed to connect to MySQL: " . $conn->connect_error;
    } else
    return $conn;
}