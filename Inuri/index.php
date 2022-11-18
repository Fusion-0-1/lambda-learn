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
    <div class="container">
        <div class="img">
            <img src="img/login.png">
        </div>
        <div class="login-container">

            <form name="form" method="POST" action="login.php">
                <img src="img/logo.jpg" alt="">
                <h2>Institute of Fusion</h2>
                
                <h3>Login</h3>
                <h1>Welcome</h1>                
        
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
                <div class="input-div">
                    <div>
                        <input type="text" id="user" name="user" placeholder="Username" class="input"> <br><br>
                    </div>
                    <div>
                        <input type="password" id="pass" name="pass" placeholder="Password" class="input"><br><br>
                    </div>
                    <input type="submit" id="btn" class="btn" value="Login" name="submit">
                </div>
                
            </form>
        
    </div>
    
    </div>
</body>
</html>