<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    
<div id="logo">
    <img src="img/logo.jpg" alt="" class="img">
</div>
<?php 
if(isset($_SESSION['User'])){
   
   echo "<div class='user'><h4>{$_SESSION['User']}</h4></div>";
   //echo '<div class="top-menu"><h1>_</h1><a href="logout.php?logout" class="logout">Logout</i></i></a></div>';
} 
else{
   header("location:index.php");
}
?>
    <nav class="navbar">
        <div class="display">
        <ul>
            <li><a href="dashboard.php" class="nav-link">
                <i class="fa-solid fa-house"></i>
            </a></li>
            <li><a href="#" class="nav-link">
                <i class="fa-solid fa-calendar-days"></i>
            </a></li>
            <li><a href="#" class="nav-link">
                <i class="fa-solid fa-address-card"></i>     
           </a></li>              
            <li><a href="#" class="nav-link">
                <i class="fa-solid fa-chart-simple"></i>            
            </a></li>

            <li>
                <?php 
                    if(isset($_SESSION['User'])){
   
                        //echo "<div class='user'>{$_SESSION['User']}</div>";
                        echo '<a href="logout.php?logout" class="logout nav-link"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
                    } 
                    else{
                        header("location:index.php");
                    }
                ?>
            </li>
            </ul>
        </div>
    </nav>
    
</body>
</html>