<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "lambda_dh";

$connection = new mysqli($hostname, $username, $password, $database);

if($connection -> connect_error) {
   die("Connection unsuccessfull". $connection -> connect_error);
}

?>