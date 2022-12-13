<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "users";

$connection = mysqli_connect('localhost', 'root','','users');

// checking connection
if(mysqli_connect_errno()){
    die('Database connection failed '. mysqli_connect_error());
}

?>
