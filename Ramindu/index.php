<?php
    session_start();
    include('db.php');
?>
</head>
<?php
    if (!isset($_SESSION['reg_no'])) {
        header("Location: login.php");
        die();
    } else {
        include('home.php');
        // include ('../public/home.php');
    }
    include('footer.html');
?>
    
