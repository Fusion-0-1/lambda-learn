<?php
session_start();
include('db.php');
include('navbar.php');
?>
<link href="css/main.css" rel="stylesheet">
<link href="css/home.css" rel="stylesheet">
</head>
<body>
<div class="main-container outer border flex flex-column v-center h-center">
    <h1 id="row1">Dashboard</h1>
    <div id="row2" class="dashboard-row flex flex-row h-justify flex-wrap">
        <a href="./home.php?courses=true" class="dashboard-card flex flex-column text-no-decoration">
            <div class="dashboard-card-icon text-center">
                <img src="./images/dashboard/Course%20Assign.png" alt="Reports">
            </div>
            <h3 class="text-center">Courses</h3>
        </a>

        <a href="#" class="dashboard-card flex flex-column text-no-decoration">
            <div class="dashboard-card-icon text-center">
                <img src="./images/dashboard/Combo%20Chart.png" alt="Reports">
            </div>
            <h3 class="text-center">Reports</h3>
        </a>

        <a href="#" class="dashboard-card flex flex-column text-no-decoration">
            <div class="dashboard-card-icon text-center">
                <img src="./images/dashboard/News.png" alt="Reports">
            </div>
            <h3 class="text-center">Announcements</h3>
        </a>
    </div>

    <div id="row3" class="flex flex-row dashboard-row">
        <a href="#" class="dashboard-card flex flex-column text-no-decoration">
            <div class="dashboard-card-icon text-center">
                <img src="./images/dashboard/Timesheet.png" alt="Reports">
            </div>
            <h3 class="text-center">Calendar</h3>
        </a>
    </div>
    <?php
    if (isset($_GET['courses'])){
        ?>
        <script>
            document.getElementById('row1').style.display = 'none';
            document.getElementById('row2').style.display = 'none';
            document.getElementById('row3').style.display = 'none';
        </script>
        <h1>Courses</h1>
        <div class="dashboard-row flex flex-row h-justify flex-wrap">
            <a href="./course.php" class="dashboard-card flex flex-column text-no-decoration">
                <div class="dashboard-card-icon text-center">
                    <img src="./images/dashboard/Edit%20Property.png" alt="Reports">
                </div>
                <h3 class="text-center">Create Courses</h3>
            </a>

            <a href="#" class="dashboard-card flex flex-column text-no-decoration">
                <div class="dashboard-card-icon text-center">
                    <img src="./images/dashboard/People%20Skin%20Type%208.png" alt="Reports">
                </div>
                <h3 class="text-center">Assign Users</h3>
            </a>

            <a href="#" class="dashboard-card flex flex-column text-no-decoration">
                <div class="dashboard-card-icon text-center">
                    <img src="./images/dashboard/Course%20Assign.png" alt="Reports">
                </div>
                <h3 class="text-center">Course Overview</h3>
            </a>
        </div>
    <?php
    }
    ?>
</div>
</body>
