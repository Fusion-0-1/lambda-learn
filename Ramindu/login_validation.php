<?php
session_start();
include('db.php');

$reg_no = $_POST['reg_no'];
$password = $_POST['password'];

$sql = "SELECT * FROM Users WHERE reg_no='$reg_no' AND password='$password'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (mysqli_num_rows($result) == 1 && $row['password'] == $password) {
    $_SESSION['reg_no'] = $row['reg_no'];
    $_SESSION['f_name'] = $row['f_name'];
    $_SESSION['l_name'] = $row['l_name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['contact_no'] = $row['contact_no'];
    $_SESSION['login_date_time'] = time();


    $sql = "UPDATE Users SET login_date_time='" . date('Y-m-d H:i:s', $_SESSION['login_date_time']) . "', active_status=1 WHERE reg_no='$reg_no'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    header("location: home.php", true, 301);
    die();
} else {
    header("location: login.php?error=1", true, 301);
    die();
}
?>
