<?php
    include('db.php');

    if (session_status() === PHP_SESSION_ACTIVE) {
        if (!isset($_SESSION['reg_no'])) {
            $_SESSION['login_date_time'] = time();
            header("location: login.php");
            die();
        } else if (time() - $_SESSION['login_date_time'] > 86400*3) {
            // session started more than 30 minutes ago
            $sql = "UPDATE Users SET logoutDateTime='" .date('Y-m-d H:i:s', time()). "', activeStatus=0 WHERE reg_no='" .$_SESSION['reg_no']. "'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            
            // session_regenerate_id(true); // change session ID for the current session and invalidate old session ID
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
            header("location: login.php");
            die();
        }
    }
?>
