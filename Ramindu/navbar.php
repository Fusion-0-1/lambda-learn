<?php
    include('db.php');
    include('detect_login.php');
?>
<link href="css/sidebar.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

<div class="sidebar">
    <a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a>
    <a href="course.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i></a>
    <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
</div>

<?php
    include('footer.html');
?>
