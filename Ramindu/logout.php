<?php
session_start();
include('db.php');

if (isset($_SESSION['reg_no'])) {
    $sql = "UPDATE Users SET logout_date_time='" .date('Y-m-d H:i:s', time()). "', active_status=0 WHERE reg_no='".$_SESSION['reg_no']."'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    session_unset();
    session_destroy();
    header("location: login.php");
    die();
} else {
    header("location: login.php");
    die();
}
?>