<?php
session_start();
include ("db.php");
$course_code = $_GET['course_code'];
$course_name = $_GET['course_name'];

$duplicates = "SELECT * FROM Courses WHERE course_code = '$course_code'";
$result = mysqli_query($conn, $duplicates) or die (mysqli_error($conn));

if (mysqli_num_rows($result) > 0) {
    header("location: course.php?error=1");
} else {
    $sql = "INSERT INTO Courses (course_code, course_name) VALUES ('".$course_code."', '".$course_name."')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location: course.php");
}

die();
