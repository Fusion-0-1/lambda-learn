<?php 
    include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">


</head>
<body>
    
    <h1 class="text-center">Dashboard</h1>
    <div class="dashboard">
<section>
        <div class="container">
            
                <a href="student_view.php" class="dash-link">
                <div class="card">
                 <img src="img/student.png" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Student Profile</h4>
                 </div>
                </a>   
            
                <a href="#" class="dash-link">
                <div class="card">
                 <img src="img/lecturer.jpg" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Lecturer Profile</h4>
                 </div>
                </a>

                <a href="#" class="dash-link">
                <div class="card">
                 <img src="img/coordinator.png" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Coordinator Profile</h4>
                 </div>
                </a>

                <a href="#" class="dash-link">
                <div class="card">
                 <img src="img/admin.png" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Administrator Profile</h4>
                 </div>
                </a>
                <a href="#" class="dash-link">
                <div class="card">
                 <img src="img/announcement.png" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Announcements</h4>
                 </div>
                </a>
                <a href="#" class="dash-link">
                <div class="card">
                 <img src="img/reports.jpg" alt="" class="img-dashboard"> <br><br>                 
                 <h4>Reports</h4>
                 </div>
                </a>
        </div>
        </section>
    </div>
</body>
</html>