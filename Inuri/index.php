<?php 
    include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login login_container flex-wrap flex align-stretch h-center margin-top">
    <div class="background_image_container">
        <img src="img/login.png" alt="login">
    </div>
    <div class="login_container_form flex align-stretch flex-column v-center h-center main-container border">
        <div class="login_container_logo">
            <img src="img/logo.jpg" alt="logo">
        </div>
        <h3 class="text-center text-normal">Institute of Fusion</h3>
        <h2 class="text-normal">Login</h2>
        <h1>Welcome</h1>
        <div id="error" class="error-message">
            <?php
            if(@$_GET['Empty'] == true){
                ?>

                <div class="alert">
                    <?php echo $_GET['Empty']?>
                </div>

                <?php
            }
            ?>

            <?php
            if(@$_GET['Invalid'] == true){
                ?>

                <div class="alert">
                    <?php echo $_GET['Invalid']?>
                </div>

                <?php
            }
            ?>
        </div>
        <form name="form" method="POST" action="login.php" class="login_form flex align-stretch flex-column h-center">
            <input type="text" id="user" name="user" placeholder="Username" class="input margin-top" required> <br>
            <input type="password" id="pass" name="pass" placeholder="Password" class="input margin-top" required><br>
            <input type="submit" id="btn" value="Login" name="submit" class="dark-btn margin-top">
        </form>
    </div>
</div>

</body>
</html>