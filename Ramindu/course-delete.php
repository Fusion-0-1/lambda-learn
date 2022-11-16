<?php
include ('db.php');

$course_code = $_GET['course_code'];

$sql = "DELETE FROM Courses WHERE course_code = '" . $course_code . "'";
$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

echo $course_code;
