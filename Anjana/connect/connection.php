<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "anjana_lamda";

$connection = mysqli_connect('localhost', 'root','','anjana_lamda');

// checking connection
if(mysqli_connect_errno()){
    die('Database connection failed '. mysqli_connect_error());
}

?>
