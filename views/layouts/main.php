<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
} else {
    // Session timeout after 30 minutes
    if (time() - $_SESSION['last_activity'] > 60*30) {
        $user = unserialize($_SESSION['user']);
        $user->setLogout();
        session_destroy();
        header('Location: /logout');
        exit;
    }
    $_SESSION['last_activity'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Browser meta tags -->
    <meta charset="UTF-8" />
    <meta content="Lambda Learning Management System" name="description" />
    <meta
            content="Lambda, Learning Management System, LMS, Lambda Learning, University"
            name="keywords"
    />
    <meta content="Fusion 0-1" name="author">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Open Graph meta tags for social media sharing -->
    <meta content="Lambda - Fusion 0-1" property="og:title" />
    <meta
            content="Lambda Learning Management System"
            property="og:description"
    />

    <!--  Scripts  -->
    <script type="text/javascript" src="./js/main.js"></script>

    <!-- Fonts -->
    <!-- CSS -->
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/form.css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <title>Lambda - Learn</title>
</head>
<body>
<div class="responsive-sidebar responsive-icons flex v-center h-center flex-column" id="sidebar">

    <?php if ($_SESSION['user-role'] == 'Student' or $_SESSION['user-role'] == 'Lecturer') {?>
        <a href="/course_overview"><img src="images/dashboard/courses.svg" id="sidenav-element"></a>
        <a href="/kanbanboard"><img src="images/dashboard/kanbanBoard.svg" id="sidenav-element"></a>
    <?php }

    if ($_SESSION['user-role'] == 'Coordinator') {?>
            <a href="/course_overview"><img src="images/dashboard/courseOverview.svg" id="sidenav-element"></a>
    <?php }

    if ($_SESSION['user-role'] == 'Admin') {?>
        <a href="/" class="hide"><img src="images/dashboard/userAccounts.svg" id="sidenav-element"></a>
        <a href="/attendance_upload"><img src="images/dashboard/attendanceReport.svg" id="sidenav-element"></a>
    <?php }

    if ($_SESSION['user-role'] == 'Coordinator') {?>
    <a href="/attendance_course_progress"><img src="images/dashboard/reports.svg" id="sidenav-element"></a>

    <?php }?>

    <a href="/"><img src="images/dashboard/homePage.svg" id="sidenav-element"></a>
    <a href="/site_announcement"><img src="images/dashboard/announcement.svg" id="sidenav-element"></a>

    <?php if ($_SESSION['user-role'] == 'Admin') {?>
        <a href="/utilization"><img src="images/dashboard/storage.svg" id="sidenav-element"></a>
    <?php }?>

        <a href="/calender"><img src="images/dashboard/calendar.svg" id="sidenav-element"></a>


</div>
<div class="topbar flex h-justify v-center font">
    <div class="elements">
        <img src="/images/logo_without_team_name.svg" alt="logo" class="logo flex flex-wrap">
    </div>

    <div class="v-center flex">
        <div class="flex elements responsive-hide">
            <div class="flex">
                <input type="search" class="search-bar input" placeholder="Search" >
            </div>
            <div class="flex v-center">
                <span><button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button></span>
            </div>
        </div>
        <?php
        if ($_SESSION['user-role'] == 'Student') {?>
        <a href="/leaderboard"><div class="elements responsive-hide">
            <span class="point-border point">
                <span class="text-bold">1204</span>
                <span class="text-normal">Points</span>
            </span>
            <span class="point-border rank text-bold">
                5
            </span>
            </div></a>
        <?php }?>


        <div class="elements responsive-hide">
                <a href="/profile">
                    <?php
                        $profile = unserialize($_SESSION['user']);
                        echo $profile->getFirstName()." ".$profile->getLastName();
                    ?>
                </a>
        </div>

        <div class="elements h-center responsive-hide">
            <img src="/images/profile.png" alt="profile" class="profile-nav">
        </div>

        <div class="elements responsive-hide">
            <a href="/logout"><img src="images/dashboard/Logout.svg" id="sidenav-element"></i></a>
        </div>

        <div class="elements">
            <a class="icon" id="hamburger_icon"><i class="fa-solid fa-bars"></i></a>
        </div>
    </div>

    <div id="modal_navbar" class=" hide flex flex-column">
        <div class="border-modal"><a href="/profile" class="modal-text"><img src="images/dashboard/userAccounts.svg" id="sidenav-element">Profile</a></div>
        <div class="border-modal"><a class="modal-text"><img src="images/dashboard/leaderBoard.svg" id="sidenav-element">Leaderboard</a></div>
        <div class="border-modal"><a href="/logout" class="modal-text"><img src="images/dashboard/Logout.svg" id="sidenav-element">Logout</a></div>
    </div>

</div>



<div class="container">
    {{content}}
</div>

<script>
    var hamburger_btn = document.getElementById("hamburger_icon");
    var modal_nav = document.getElementById("modal_navbar");
    hamburger_btn.onclick = function (){
        modal_nav.classList.remove("hide");
    }
</script>

</body>
</html>