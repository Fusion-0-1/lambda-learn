<?php
include ('db.php');

$course_code = $_GET['course_code'];
$course_name = $_GET['course_name'];

if (isset($_GET['course_code'])) {
    $sql = "UPDATE Courses SET course_name = '" . $course_name . "' WHERE course_code = '" . $course_code . "'";
    $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
    header("location: course.php?update=1&course_code=" . $course_code);
} else {
    header("location: course.php?error=1");
}
