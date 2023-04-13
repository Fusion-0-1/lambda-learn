<link rel="stylesheet" href="css/dashboard.css">

<div id="primary-dashboard" class="border main-container v-center flex-gap responsive-container">
    <div class="flex flex-row h-center">
        <h3>Dashboard</h3>
        <?php
        try {
            if (unserialize($_SESSION['user'])->isCoordinator()) {
                $_SESSION['user-role'] = $_GET['user-role'] ?? 'Coordinator';
            ?>
        <form class="selector flex flex-row v-center" method="get" action="/">
            <p>Account : </p>
            <select onchange="this.form.submit()" name="user-role">
                <option value="Lecturer">Lecturer</option>
                <option value="Coordinator" <?php if($_SESSION['user-role'] == 'Coordinator') echo "selected"?>>
                    Coordinator
                </option>
            </select>
        </form>
        <?php }} catch (\Throwable $th) {} ?>
    </div>
    <div class="card">
        <!-- Common cards -->
        <a href="/calender" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/calendar.svg" alt="Calendar">
                </div>
                <div class="card-name">Calendar</div>
            </div>
        </a>


        <a href="/site_announcement" class="link">
            <div class="cards">
                <div class="cards-inside cards-inside-announcement">
                    <img src="./images/dashboard/announcement.svg" alt="Announcement">
                </div>
                <div class="card-name">Announcement</div>
            </div>
        </a>


        <?php if ($_SESSION['user-role'] == 'Student') {?>
            <a href="/leaderboard" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/leaderBoard.svg" alt="Leader Board">
                    </div>
                    <div class="card-name">Leaderboard</div>
                </div>
            </a>
        <?php } ?>


        <?php if ($_SESSION['user-role'] == 'Coordinator') {?>
            <a href="/attendance_course_progress" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/reports.svg" alt="Reports">
                    </div>
                    <div class="card-name">Reports</div>
                </div>
            </a>
        <?php } ?>


        <?php if ($_SESSION['user-role'] == 'Admin') {?>
            <a href="/attendance_upload" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/attendanceReport.svg" alt="Upload Attendance">
                    </div>
                    <div class="card-name">Upload Attendance</div>
                </div>
            </a>

            <a onclick="displayAdminDashboard()" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/userAccounts.svg" alt="User Accounts">
                    </div>
                    <div class="card-name">User Accounts</div>
                </div>
            </a>


            <a href="/utilization" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/storage.svg" alt="Storage Utilization">
                    </div>
                    <div class="card-name">Storage Utilization</div>
                </div>
            </a>
        <?php } ?>

        <?php if ($_SESSION['user-role'] == 'Student' or $_SESSION['user-role'] == 'Lecturer') {?>
            <a href="/kanbanboard" class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/kanbanBoard.svg" alt="Kanban Board">
                    </div>
                    <div class="card-name">Kanban Board</div>
                </div>
            </a>
        <?php } ?>

        <?php if ($_SESSION['user-role'] != 'Admin') {?>

            <a <?php if($_SESSION['user-role'] != 'Coordinator') echo 'href="/course_overview"';
            else echo 'onclick=displayCoordinatorDashboard()'?> class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <img src="./images/dashboard/<?php
                        if($_SESSION['user-role'] != 'Coordinator') echo 'courses.svg';
                        else echo 'courseOverview.svg'?>"
                             alt="Courses">
                    </div>
                    <div class="card-name">Courses</div>
                </div>
            </a>
        <?php } ?>
    </div>
</div>


<!-------- Coordinator secondary dashboard, i.e. Courses Dashboard -------->
<div id="coordinator-dashboard-2" class="border main-container v-center flex-gap responsive-container" hidden>
    <h3>Courses</h3>
    <div class="card">
        <a href="/course_creation" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/createSettings.svg" alt="Create Course">
                </div>
                <div class="card-name">Create Course</div>
            </div>
        </a>
        <a href="/assign_users_to_courses" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/assignUsers.svg" alt="Assign Users">
                </div>
                <div class="card-name">Assign Users</div>
            </div>
        </a>
        <a href="/course_overview" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/courseOverview.svg" alt="Course Overview">
                </div>
                <div class="card-name">Course Overview</div>
            </div>
        </a>
    </div>

</div>

<!-------- Admin secondary dashboard, i.e. Accounts Dashboard -------->
<div id="admin-dashboard-2" class="border main-container v-center flex-gap responsive-container" hidden>
    <h3>Accounts</h3>
    <div class="card">
        <a href="/account_creation?type=Student" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/studentAccount.svg" alt="Student Account">
                </div>
                <div class="card-name">Student Account</div>
            </div>
        </a>
        <a href="/account_creation?type=Lecturer" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/lecturerAccount.svg" alt="Lecturer Account">
                </div>
                <div class="card-name">Lecturer Account</div>
            </div>
        </a>
        <a href="/account_creation?type=Admin" class="link">
            <div class="cards">
                <div class="cards-inside">
                    <img src="./images/dashboard/administratorAccount.svg" alt="Administrator Account">
                </div>
                <div class="card-name">Administrator Account</div>
            </div>
        </a>
    </div>

</div>

<script>
    function displayCoordinatorDashboard() {
        document.getElementById('primary-dashboard').hidden = true;
        document.getElementById('coordinator-dashboard-2').hidden = false;
    }
    function displayAdminDashboard() {
        document.getElementById('primary-dashboard').hidden = true;
        document.getElementById('admin-dashboard-2').hidden = false;
    }

</script>