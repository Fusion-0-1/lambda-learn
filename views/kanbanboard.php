<link rel="stylesheet" href="css/kanbanboard.css">
<script src="js/kanbanboard.js" defer></script>

<div class="border main-container v-center flex flex-column flex-gap responsive-container">
    <h3> Kanban Board </h3>    

    <div class="modal" id="card-add-modal">
            <div class="card-add-modal border border-radius flex flex-column">
                <form action="#" method="POST">
                    <div class="flex"><input type="text" name="card-header" id="card-header-modal" class="card-header  card-header-modal border border-radius" placeholder="Card Title" required></div>
                    <div class="flex"><textarea name="card-body" class="card-body card-body-modal border border-radius" placeholder="Card Content"></textarea></div>
                    <div class="card-footer border border-radius flex flex-row h-justify v-center">
                        <div class="card-deadline-label">
                            <label>Deadline :</label>
                            <input type="date" name="card-deadline" class="card-deadline">
                        </div>
                        <div id="radio-todo"><input type="radio" name="card-status" value="To Do"> To Do </div>
                        <div id="radio-inprogress"><input type="radio" name="card-status" value="In Progress"> In Progress </div>
                        <div id="radio-done"><input type="radio" name="card-status" value="Done"> Done </div>
                        
                    </div>
                    <div class="card-save-container flex h-center">
                        <input type="submit" value="Cancel" class="modal-cancel border-radius" id="card-save-cancel">
                        <input type="submit" value="Save" class="card-save border-radius" id="card-add-save">
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
            
            <div class="droppable">
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Complete Datatabase Note</div>
                    <div class="card-body border border-radius">
                        <p> Complete database note together with diagrams and codes </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2022-12-10</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Progress Check Presentation</div>
                    <div class="card-body border border-radius">
                        <p> Prepare script, check prototype, check implemented functionalities </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2023-02-09</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Update Slides</div>
                    <div class="card-body border border-radius">
                        <p> Update data structures presentation slides </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2023-01-25</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="card-list border border-radius flex flex-column">
            <div class="list-header flex h-justify v-center">
                    <h5> In Progress</h5>
                    <div class="add-card"><button class="card-button" id="card-add-inprogress"><span class="fa fa-plus-square"></span></button></div>
            </div>
            
            <div class="droppable">
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Install R studio</div>
                    <div class="card-body border border-radius">
                        <p> Including the GUI, and explore the software </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2022-12-30</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Automata assignment</div>
                    <div class="card-body border border-radius">
                        <p> Language grammar types, ambiuous grammar </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2022-12-24</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Re-read project documents</div>
                    <div class="card-body border border-radius">
                        <p> Important design decisions document  </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2023-02-10</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="card-list border border-radius flex flex-column">
            <div class="list-header flex h-justify v-center">
                    <h5> Done </h5>
                    <div class="add-card"><button class="card-button" id="card-add-done"><span class="fa fa-plus-square"></span></button></div>
            </div>
            
            <div class="droppable">
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Read!</div>
                    <div class="card-body border border-radius">
                        <p> Algorithms resouce book page 154-170 </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2022-12-03</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">DM Calculations </div>
                    <div class="card-body border border-radius">
                        <p> Modular arithematics, primes and euclidian things </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2023-02-14</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="draggable flex flex-column align-stretch h-center border border-radius" draggable="true">
                    <div class="card-header border-radius text-bold">Electronics note </div>
                    <div class="card-body border border-radius">
                        <p> Complete the note with circuit diagrams  </p>
                    </div>
                    <div class="card-footer border flex flex-row h-justify v-center">
                        <div class="card-deadline">2023-02-20</div>
                        <div class="card-options flex flex-row h-justify">
                            <div>
                                <button type="submit" name="card-update" class="card-button">
                                    <span class="fa fa-pen"></span>
                                </button>
                            </div>
                            <div>
                                <form action="#" method="POST">
                                    <button type="submit" name="card-delete" class="card-button" onclick="return confirm('Are you sure?');">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>