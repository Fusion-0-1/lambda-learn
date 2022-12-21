<?php
session_start();
require_once "/Applications/XAMPP/xamppfiles/htdocs/lambda-learn/Dilanga/connect.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $task_id = $_POST['card-delete'];
}    

    $delete = "DELETE FROM `KanbanTask` WHERE task_id = '$task_id'";

    $result = $connection -> query($delete);    

    if($result){
        header("location: kanban.php");
        exit(0);
    }
    else{
        header("location: kanban.php");
        exit(0);
    }

?>
