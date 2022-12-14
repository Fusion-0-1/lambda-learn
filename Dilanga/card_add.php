<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/Dilanga/connect.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['card-header'];
    $description = $_POST['card-body'];
    $due_date = $_POST['card-deadline'];
    $state = $_POST['card-status'];
}    

    $insert = "INSERT INTO `KanbanTask` (title, description, due_date, state) VALUES ('$title', '$description', '$due_date', '$state')";

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

