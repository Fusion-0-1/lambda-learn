<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/Dilanga/connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lambda Learn</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css"> 
</head>

<body>

    <div class="navbar">
        <div class="logo-container">
            <img class="logo" src="images/logo.png" alt="lambda-learn logo">
        </div>
        <div class="navbar-items">
            <span class="fas fa-graduation-cap"></span>
            <a href="kanban.php"><span class="fas fa-clipboard-check"></span></a>
            <a href="dashboard.php"><span class="fas fa-home"></span></a>
            <span class="fas fa-bullhorn"></span>
            <span class="fas fa-calendar-alt"></span>
        </div> 
    </div>
    
    
    <div class="main-container">
        <div class="title"><h1>Kanban Board</h1></div>

        <div class="card-modal-container-new">
            <form action="card_add.php" method="POST">
                <div><input type="text" name="card-header" class="card-header card-border" placeholder="Card Title"></div>
                <div><textarea name="card-body" class="card-body card-border" placeholder="Card Content"></textarea></div>
                <div class="card-footer-modal">
                    <div class="card-deadline-label">
                        <label>Deadline :</label>
                        <input type="date" name="card-deadline" class="card-deadline">
                    </div>
                    <div><input type="radio" name="card-status" value="To Do"> To Do </div>
                    <div><input type="radio" name="card-status" value="In Progress"> In Progress </div>
                    <div><input type="radio" name="card-status" value="Done"> Done </div>
                    
                </div>
                <div class="card-save-container">
                    <input type="submit" value="Save" class="card-save">
                </div>
            </form>
        </div>

        <div class="card-modal-container-update">
            <form action="card_add.php" method="POST">
                <div><input type="text" name="card-header" class="card-header card-border" value="<?= $done['title']; ?>"></div>
                <div><textarea name="card-body" class="card-body card-border" placeholder="Card Content"></textarea></div>
                <div class="card-footer-modal">
                    <div class="card-deadline-label">
                        <label>Deadline :</label>
                        <input type="date" name="card-deadline" class="card-deadline">
                    </div>
                    <div><input type="radio" name="card-status" value="To Do"> To Do </div>
                    <div><input type="radio" name="card-status" value="In Progress"> In Progress </div>
                    <div><input type="radio" name="card-status" value="Done"> Done </div>
                    
                </div>
                <div class="card-save-container">
                    <input type="submit" value="Save" class="card-save">
                </div>
            </form>
        </div>
        
        <div class="card-container">

            <div class="card-list">
                <div class="list-header">
                    <div><h2>To Do</h2></div>
                    <div class="add-card"><button class="card-button"><span class="fa fa-plus-square"></span></button></div>
                </div>

                <div class="droppable">

                    <?php
                        $viewtodo = "SELECT title, description, due_date FROM KanbanTask WHERE state = 'To Do'";
                        $result = $connection -> query($viewtodo);

                        if(mysqli_num_rows($result)>0) {
                            foreach($result as $todo) {
                    ?>

                    <div class="draggable" draggable="true">
                        <div class="card-header"><?= $todo['title']; ?></div>
                        <div class="card-body card-border"><?= $todo['description']; ?></div>
                        <div class="card-footer card-border">
                            <div class="card-deadline"><?= $todo['due_date']; ?></div>
                            <div class="card-options">
                                <div class="card-edit"><span class="fas fa-pen"></span></div>
                                <div class="card-delete"><span class="fa fa-trash"></span></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="card-list">
                <div class="list-header">
                    <div><h2>In Progress</h2></div>
                    <div class="add-card"><span class="fa fa-plus-square"></span></div>
                </div>

                <div class="droppable">
                    
                    <?php
                        $viewinprogress = "SELECT title, description, due_date FROM KanbanTask WHERE state = 'In Progress'";
                        $result = $connection -> query($viewinprogress);

                        if(mysqli_num_rows($result)>0) {
                            foreach($result as $inprogress) {
                    ?>

                    <div class="draggable" draggable="true">
                        <div class="card-header"><?= $inprogress['title']; ?></div>
                        <div class="card-body card-border"><?= $inprogress['description']; ?></div>
                        <div class="card-footer card-border">
                            <div class="card-deadline"><?= $inprogress['due_date']; ?></div>
                            <div class="card-options">
                                <div class="card-edit"><span class="fas fa-pen"></span></div>
                                <div class="card-delete"><span class="fa fa-trash"></span></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="card-list">
                <div class="list-header">
                    <div><h2>Done</h2></div>
                    <div class="add-card"><span class="fa fa-plus-square"></span></div>
                </div>
                <div class="droppable">

                    <?php
                        $viewdone = "SELECT task_id, title, description, due_date FROM KanbanTask WHERE state = 'Done'";
                        $result = $connection -> query($viewdone);

                        if(mysqli_num_rows($result)>0) {
                            foreach($result as $done) {
                    ?>

                    <div class="draggable" draggable="true">
                        <div class="card-header"><?= $done['title']; ?></div>
                        <div class="card-body card-border"><?= $done['description']; ?></div>
                        <div class="card-footer card-border">
                            <div class="card-deadline"><?= $done['due_date']; ?></div>
                            <div class="card-options">
                                <div>
                                    <button type="submit" name="card-update" value="<?= $done['task_id'] ?>" class="card-button">
                                        <span class="fa fa-pen"></span>
                                    </button>
                                </div>
                                <div>
                                    <form action="card_delete.php" method="POST">
                                        <button type="submit" name="card-delete" value="<?= $done['task_id'] ?>" class="card-button">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>

                </div>
            </div>          
        </div> 
    </div>

    <script>
        const droppables = document.querySelectorAll('.droppable');
        const draggables = document.querySelectorAll('.draggable');

        const newmodal = document.querySelectorAll('.card-modal-container-new');
        const newbutton = document.querySelectorAll('.add-card');
        const savebutton = document.querySelectorAll('.card-save');

        newbutton.addEventListener('click', function () {
            newmodal.style.display = 'block';
        });

        savebutton.addEventListener('click', function () {
            newmodal.style.display = 'none';
        });

        window.addEventListener('click', e => {
            if(e.target == newmodal) {
                newmodal.style.display = 'none';
            }
        });

        document.addEventListener('dragstart', e=> {
            if(e.target.classList.contains('draggable')) {
                e.target.classList.add('dragging');
            }       
        });

        document.addEventListener('dragend', e=> {
            if(e.target.classList.contains('draggable')) {
                e.target.classList.remove('dragging');
            }
        });

        droppables.forEach(droppable=> {
            droppable.addEventListener('dragover', e=> {
                e.preventDefault();
                const dragging = document.querySelector('.dragging');
                // droppable.append(dragging);
                const frontSib = getClosestFrontSibling(droppable, e.clientY);
                if (frontSib) {
                    frontSib.insertAdjacentElement('afterend',dragging);
                } else {
                    droppable.prepend(dragging);
                }
            });
        });

        function getClosestFrontSibling(droppable, draggingY) {
            const siblings = droppable.querySelectorAll('.draggable:not(.dragging');
            let result;

            for (const sibling of siblings) {
                const box = sibling.getBoundingClientRect();

                const boxCenterY = box.y + box.height / 2;
                if (draggingY >= boxCenterY) {
                    result = sibling;
                } else {
                    return result;
                }
            }
            return result;
        }

    </script>

</body>

</html>