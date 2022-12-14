<?php session_start(); ?>
<?php require_once('connect/connection.php'); ?>


<?php

    if(isset($_POST['submit'])){

        $errors = array();
        if(!isset($_POST['uname']) || strlen(trim($_POST['uname'])) < 1){
            $errors[] = 'username is missing or invalid';
        }
        if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1){
            $errors[] = 'password is missing or invalid';
        }


        if(empty($errors)){
            $uname = mysqli_real_escape_string($connection, $_POST['uname']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            

            $query = "SELECT * FROM user WHERE username= '{$uname}' AND password ='{$password}'
            LIMIT 1";


            $result_set = mysqli_query($connection,$query);

            
            if($result_set){
                if(mysqli_num_rows($result_set) ==1 ){
                    $user = mysqli_fetch_assoc($result_set);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['username'];

                    header('Location: dashboard.php');
                }else{
                    $errors[] = 'Invalid user name or password';
                }
            }else {
                $errors[] = 'Database query failed';
            }


        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./css/main.css">
</head>


<body>
    <div class="main_card">

        <div class="grid_use">
            <img class="login_page_image" src="./image/img3.jpg" alt="login page image">
        

            
                <form class="login" action="index.php" method="post">
                    <div class="field_set">
                        <img class="logo" src="./image/logo.png" alt="logo">
                            <p class="university_name">University of ABC</p>
                            <p class="login_text">Login</p>
                            <h1 class="welcome_text">Welcome</h1>

                        
                        
                        <?php
                            if (isset($errors) && !empty($errors)){
                                echo '<p class="error">Invalid Username / Password</p>';
                            }
                        ?>
                        
                        <p>
                            <input type="text" name="uname" id="" placeholder="username">
                        </p>
                        
                        <p>
                            <input type="password" name="password" id="" placeholder="password">
                        </p>

                        <p>
                            <button type="submit" name="submit">Log In</button>
                        </p>
                    </div>

                </form>
            
        </div>
    </div>
</body>

</html>
<?php mysqli_close($connection); ?>
