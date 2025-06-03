<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'ims';
$con = mysqli_connect($host, $user, $pass, $database);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

?>