<?php session_start(); ?>
<?php require_once('connect/connection.php'); ?>

<?php 
    if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
}
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
    <header>
        <div class="appname">Lamda</div>
        <div class="loggedin">Wellcome <?php echo $_SESSION['user_name']; ?>! <a href="logout.php">Log Out</a></div>
    </header>
    
        <div class="main_card">
        <h1 class="main_heading"> <b>Dashboard</b> </h1>
            <div class="card">

                <a href="#">
                    <div class="cards">
                        <div class="cards_inside">
                            <img src="./image/courses.png" alt="courses">
                        </div>
                        <h2>Courses</h2>
                    </div>
                </a>


                <a href="announcement.php">
                    <div class="cards">
                        <div class="cards_inside">
                            <img src="./image/announcement.png" alt="calender">
                        </div>
                        <h2>Announcement</h2>
                    </div>
                </a>


                <a href="#">
                    <div class="cards">
                        <div class="cards_inside">
                            <img src="./image/calendar.png" alt="announcement">
                        </div>
                        <h2>Calendar</h2>
                    </div>
                </a>


                <a href="#">
                    <div class="cards">
                        <div class="cards_inside">
                            <img src="./image/kanbanboard.png" alt="leaderBoard">
                        </div>
                        <h2>Kanban Board</h2>
                    </div>
                </a>

    
            </div>
        </div>

</body>
</html>