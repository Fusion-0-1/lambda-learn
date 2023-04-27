<link rel="stylesheet" href="css/kanbanboard.css">
<script src="js/kanbanboard.js" defer></script>

<div class="border main-container v-center flex flex-column flex-gap responsive-container">
    <h3> Kanban Board </h3>    

    <div class="modal" id="card-add-modal">
        <div class="card-add-modal modal-content border border-radius flex flex-column">
            <form method="post" action="insert_task">
                <div class="flex"><input type="text" name="card-header" id="card-header-modal" class="card-header  card-header-modal border card-border-radius" placeholder="Card Title" required></div>
                <div class="flex"><textarea name="card-body" class="card-body card-body-modal border card-border-radius" placeholder="Card Content" required></textarea></div>
                <div class="card-footer border card-border-radius flex flex-row h-justify v-center">
                    <div class="card-deadline-label">
                        <label>Deadline :</label>
                        <input type="date" name="card-deadline" class="card-deadline">
                    </div>
                    <div id="radio-todo"><input type="radio" name="card-status" value="To Do"> To Do </div>
                    <div id="radio-inprogress"><input type="radio" name="card-status" value="In Progress"> In Progress </div>
                    <div id="radio-done"><input type="radio" name="card-status" value="Done"> Done </div>
                </div>
                <div class="card-save-container flex flex-row ">
                    <input type="button" value="Cancel" class="cancel-btn btn-border-dark-blue" id="card-save-cancel">
                    <input type="submit" value="Insert" class="card-btn" id="card-add-save">
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="card-edit-modal">
        <div class="card-edit-modal modal-content border border-radius flex flex-column">
            <form method="post" action="update_task">
                <input type="hidden" name="card-id" id="card-id">
                <input type="hidden" name="card-state" id="card-state">
                <div class="flex"><input type="text" name="card-header" id="card-header-edit-modal" class="card-header card-header-modal border card-border-radius" placeholder="Card Title" required></div>
                <div class="flex"><textarea name="card-body" id="card-body-edit-modal" class="card-body card-body-modal border card-border-radius" placeholder="Card Content" required></textarea></div>
                <div class="card-footer border card-border-radius flex flex-row h-justify v-center">
                    <div class="card-deadline-label">
                        <label>Deadline :</label>
                        <input type="date" name="card-deadline" id="card-deadline-edit-modal" class="card-deadline">
                    </div>
                </div>
                <div class="card-save-container flex h-center">
                    <input type="button" value="Cancel" class="cancel-btn btn-border-dark-blue" id="card-edit-cancel">
                    <input type="submit" value="Save" class="card-btn" id="card-edit-save">
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="delete-modal">
        <div class="modal-content error-modal-content">
            <form action="delete_task" method="post">
                <input type="hidden" name="card-delete-id" id="card-delete-id">
                <div class="flex flex-column v-center h-center">
                    <img src="./images/primary_icons/error.svg">
                    <h4 id="delete-warning" class="modal-header">Are you sure you want to delete this card?</h4>
                    <section class="flex flex-row two-button-row">
                        <input type="button" value="Cancel" class="dark-btn cancel-btn" id="card-dlt-cancel">
                        <input type="submit" value="Delete" class="dark-btn error-btn">
                    </section>
                </div>
            </form>
        </div>
    </div>

    <div class="card-container flex flex-row h-around item-gap">

        <div class="card-list border border-radius flex flex-column">
            <div class="list-header flex h-justify v-center">
                    <h5>To Do</h5>
                    <div class="add-card"><button class="card-button" id="card-add-todo"><span class="fa fa-plus-square"></span></button></div>
            </div>

            <div class="droppable" data-state="1">
                <?php foreach ($toDo as $toDoTask) {?>
                    <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true" data-id="<?php echo $toDoTask->getTaskId()?>">
                        <div class="card-header border-radius text-bold"><?php echo $toDoTask->getTitle()?></div>
                        <div class="card-body border border-radius">
                            <p> <?php echo $toDoTask->getDescription()?> </p>
                        </div>
                        <div class="card-footer border flex flex-row h-justify v-center">
                            <div class="card-deadline"><?php echo $toDoTask->getDueDate()?></div>
                            <div class="card-options flex flex-row h-justify">
                                <div>
                                    <button type="submit" name="card-update" class="card-button card-update" onclick="kanbanupdate(<?php echo $toDoTask->getTaskId().",'".$toDoTask->getTitle()."','".$toDoTask->getDescription()."','".$toDoTask->getState()."','".$toDoTask->getDueDate()."'";?>)">
                                        <span class="fa fa-pen"></span>
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" name="card-delete" class="card-button" onclick="deletecard(<?php echo $toDoTask->getTaskId();?>)">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

        <div class="card-list border border-radius flex flex-column">
            <div class="list-header flex h-justify v-center">
                    <h5> In Progress</h5>
                    <div class="add-card"><button class="card-button" id="card-add-inprogress"><span class="fa fa-plus-square"></span></button></div>
            </div>

            <div class="droppable" data-state="2">
                <?php foreach ($inProgress as $inProgressTask) {?>
                    <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true" data-id="<?php echo $inProgressTask->getTaskId()?>">
                        <div class="card-header border-radius text-bold"><?php echo $inProgressTask->getTitle()?></div>
                        <div class="card-body border border-radius">
                            <p> <?php echo $inProgressTask->getDescription()?> </p>
                        </div>
                        <div class="card-footer border flex flex-row h-justify v-center">
                            <div class="card-deadline"><?php echo $inProgressTask->getDueDate()?></div>
                            <div class="card-options flex flex-row h-justify">
                                <div>
                                    <button type="submit" name="card-update" class="card-button card-update" onclick="kanbanupdate(<?php echo $inProgressTask->getTaskId().", '".$inProgressTask->getTitle()."','".$inProgressTask->getDescription()."','".$inProgressTask->getState()."','".$inProgressTask->getDueDate()."'";?>)">
                                        <span class="fa fa-pen"></span>
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" name="card-delete" class="card-button" onclick="deletecard(<?php echo $inProgressTask->getTaskId();?>)">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

        <div class="card-list border border-radius flex flex-column">
            <div class="list-header flex h-justify v-center">
                    <h5> Done </h5>
                    <div class="add-card"><button class="card-button" id="card-add-done"><span class="fa fa-plus-square"></span></button></div>
            </div>

            <div class="droppable" data-state="3">
                <?php foreach ($done as $doneTask) {?>
                    <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true" data-id="<?php echo $doneTask->getTaskId()?>">
                        <div class="card-header border-radius text-bold"><?php echo $doneTask->getTitle()?></div>
                        <div class="card-body border border-radius">
                            <p> <?php echo $doneTask->getDescription()?> </p>
                        </div>
                        <div class="card-footer border flex flex-row h-justify v-center">
                            <div class="card-deadline"><?php echo $doneTask->getDueDate()?></div>
                            <div class="card-options flex flex-row h-justify">
                                <div>
                                    <button type="submit" name="card-update" class="card-button card-update" onclick="kanbanupdate(<?php echo $doneTask->getTaskId().", '".$doneTask->getTitle()."','".$doneTask->getDescription()."','".$doneTask->getState()."','".$doneTask->getDueDate()."'";?>)">
                                        <span class="fa fa-pen"></span>
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" name="card-delete" class="card-button" onclick="deletecard(<?php echo $doneTask->getTaskId();?>)">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>
</div>