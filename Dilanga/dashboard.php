<?php 

session_start(); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lambda Learn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css"> 
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img class="logo" src="images/logo.png" alt="lambda-learn logo">
        </div>
        <div class="navbar-items">
            <span class="fas fa-graduation-cap"></span>
            <a href="kanban.php"><span class="fas fa-clipboard-check"></span></a>
            <a href="dashboard.php"><span class="fas fa-home"></span></a>
            <span class="fas fa-bullhorn"></span>
            <span class="fas fa-calendar-alt"></span>
        </div> 
    </div>
    
    
    <div class="main-container">
        <div class="title"><h1>Dashboard</h1></div>
        <div class="card-container">
            <div class="dashboard-card-list">
                <div class="dashboard-card">
                    <div class="dashboard-card-icon"><span class="fas fa-graduation-cap"></span></div>
                    <div> <h2 class="dashboard-card-title">Courses</h2></div>
                </div>
                <div class="dashboard-card">
                    <div class="dashboard-card-icon"><span class="fas fa-bullhorn"></span></div>
                    <div> <h2 class="dashboard-card-title">Announcements</h2></div>
                </div>
            </div>
            <div class="dashboard-card-list">
                <div class="dashboard-card">
                    <div class="dashboard-card-icon"><span class="fas fa-calendar-alt"></span></div>
                    <div> <h2 class="dashboard-card-title">Calendar</h2></div>
                </div>
                <div class="dashboard-card">
                    <div class="dashboard-card-icon"><span class="fas fa-award"></span></div>
                    <div> <h2 class="dashboard-card-title">Leaderboard</h2></div>
                </div>
            </div>
            <div class="dashboard-card-list">
                 <div class="dashboard-card">
                    <div class="dashboard-card-icon"><a href="./kanban.php"><span class="fas fa-clipboard-check"></a></span></div>
                    <div><a href="./kanban.php" class="dashboard-link"><h2 class="dashboard-card-title">Kanban Board</h2></a></div>
                </div>
            </div>
        </div>          
            
    </div>
    <script src="./script.js"></script>
</body>
</html>
