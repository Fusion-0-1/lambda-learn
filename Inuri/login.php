<?php
    
    require_once("connection.php");
    session_start();

    if(isset($_POST['submit'])){
        if(empty($_POST['user']) || empty($_POST['pass'])){

            //error message will display if user doesn't fill any field

            header("location: index.php?Empty=Please fill all the blanks");
        }
        else{
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $query = "select * from login where username = '$username' and password = '$password'";

            $result = mysqli_query($conn, $query);

            if(mysqli_fetch_assoc($result)){
                $_SESSION['User'] = $username;
                header("location:dashboard.php");
            }
            else{
                //if username or password doesn't match
                header("location:index.php?Invalid=Incorrect username or password.");
            }
        }
    }

?>