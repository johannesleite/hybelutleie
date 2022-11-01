<?php

$user = 'root';
$password = '12345';
$db = 'hybelprosjektutkast';

$conn = new mysqli('localhost', $user, $password, $db) or die("unable to connect");

if ($conn->connect_errno) {
    echo "failed to connect to MySQL: " . $conn->connect_error;
}