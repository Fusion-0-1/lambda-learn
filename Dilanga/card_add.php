<?php
session_start(); 
require_once "/Applications/XAMPP/xamppfiles/htdocs/lambda-learn/Dilanga/connect.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['card-header'];
    $description = $_POST['card-body'];
    $due_date = $_POST['card-deadline'];
    $state = $_POST['card-status'];
}    

    if ($due_date) {
        $insert = "INSERT INTO `KanbanTask` (title, description, due_date, state) VALUES ('$title', '$description', '$due_date', '$state')";
    }

    else {
        $insert = "INSERT INTO `KanbanTask` (title, description, state) VALUES ('$title', '$description', '$state')";
    }
    $result = $connection -> query($insert);    

    if($result){
        header("location: kanban.php");
        exit(0);
    }
    else{
        header("location: kanban.php");
        exit(0);
    }

?>
