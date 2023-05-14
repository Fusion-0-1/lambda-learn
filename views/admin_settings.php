<link rel="stylesheet" href="css/assign_users.css">

<!--Success and error message model on the bottom right to display whether user assigned successfully-->
<?php use app\model\User\Lecturer;

if(isset($msg)){
    if(isset($is_coordinator_updated)){?>
        <div id="mssg-modal" class="<?php if ($is_coordinator_updated) echo "success-mssg"; else echo "error-mssg";?> text-justify">
            <p><?php echo $msg ?></p>
        </div>
    <?php } elseif(isset($is_settings_setup)){?>
        <div id="mssg-modal" class="<?php if ($is_settings_setup) echo "success-mssg"; else echo "error-mssg";?> text-justify">
            <p><?php echo $msg ?></p>
        </div>
    <?php } elseif(isset($is_semester_started)){?>
        <div id="mssg-modal" class="<?php if ($is_semester_started) echo "success-mssg"; else echo "error-mssg";?> text-justify">
            <p><?php echo $msg ?></p>
        </div>
    <?php }
}?>


<div id="file-upload-container" class="border main-container v-center flex-gap">
    <div class="flex flex-row h-justify responsive-card">
        <form action="/update_coord_options" method="post" name="assign_coordinator_form"
              class="main-container border flex flex-column flex-gap width-full" id="assign_coordinator">
            <h3>Assign Coordinator</h3>

            <div class="flex flex-column flex-gap">
                <label>Lecturer</label>
                <label for="lecturer_regno_name"></label>
                <select class="input" id="lecSelect" name="lecturer_regno_name" required>
                    <option value="" disabled hidden>Select a batch...</option>
                    <?php
                    foreach ($lecturers as $lecturer) {
                        echo "<option>" . $lecturer['reg_no'] . "-" .
                            Lecturer::getLecturerName($lecturer['reg_no']) . "</option>";
                    } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Batch year</label>
                <label for="batch_year"></label>
                <select class="input" id="batchYearSelect" name="batch_year" required>
                    <option value="" disabled hidden>Select a batch...</option>
                    <?php
                    foreach($batch_years as $year) { ?>
                    <option><?php echo $year?></option>
                   <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Degree Program</label>
                <select class="input" id="degreeProgramSelect" name="degree_program" required>
                    <option value="" disabled hidden>Select a degree program...</option>
                    <?php
                    foreach($degree_programs as $degree_program) {
                        echo "<option>$degree_program</option>";
                    } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <div class="flex flex-row flex-gap ">
                    <br><button type="submit" id="assignCoordinatorBtn"
                                name="assign" class="edit-btn-text margin-top">Assign</button>
                    <button type="submit" id="removeCoordinatorBtn"
                            name="remove" class="edit-btn-text margin-top" disabled>Remove</button>
                </div>
            </div>
        </form>

        <form action="/update_academic_settings" method="post"
              class="main-container border flex flex-column flex-gap width-full" id="assign_lecturers">
            <input type="hidden" name="assign_lecturer">
            <h3>Academic Semester</h3>
            <div class="flex flex-column flex-gap">
                <label>Semester Starts</label>
                <input type="date" class="input" name="sem_start_date" value="<?php echo $sem_start?>" required>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Semester End</label>
                <input type="date" class="input" name="sem_end_date" value="<?php echo $sem_end?>" required>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Semester Per Year</label>
                <select class="input" name="sem_count_year" required>
                    <option selected hidden><?php echo $sem_count_year ?></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>


            <div class="flex flex-column flex-gap ">
                <br><button class="edit-btn-text margin-top">Update</button>
            </div>
        </form>
    </div>

    <form class="main-container border flex flex-column" action="/start_new_sem" method="post">
        <h3>Start a new academic semester</h3>
        <p class="csv-header-format">
            Starting new semester will&nbsp; <b>unassigned all students</b> &nbsp;from the <b>
                currently assigned courses</b>.
            Course content and lecturers will be remained unchanged.
            <br>
            <b>This action is irreversible.</b>
        </p>

        <div class="flex flex-column flex-gap">
            <br><button class="edit-btn-text margin-top" <?php if($isSemesterEnd) echo "disabled";?>>Start new semester</button>
        </div>
    </form>

<script>
    // @description coordinatorRegNos and coordinatorDegreeCode are arrays of coordinator
    // reg nos and degree codes **in order**
    let coordinatorRegNos = <?php echo json_encode($coordinatorRegNos); ?>;
    let coordinatorDegreeCode = <?php echo json_encode($coordinatorDegreeCode); ?>;
console.log(coordinatorRegNos);
console.log(coordinatorDegreeCode);
    let lec_select_element = document.getElementById("lecSelect");
    let batch_year_element = document.getElementById("batchYearSelect");
    let degree_program_select = document.getElementById("degreeProgramSelect");

    lec_select_element.addEventListener("change", function () {
        enableBtns();
    });
    batch_year_element.addEventListener("change", function () {
        enableBtns();
    });
    degree_program_select.addEventListener("change", function () {
        enableBtns();
    });


    // @description Enable or disable buttons according to the selected values
    //              This being checked by comparing the index of the selected value
    // @return void
    function enableBtns() {
        const reg_no = document.getElementById("lecSelect").value.split("-")[0];
        const batchYear = document.getElementById("batchYearSelect").value;
        const degreeProgram = document.getElementById("degreeProgramSelect").value;

        let selectedRegNoIndex = coordinatorRegNos.indexOf(reg_no)
        let selectedDegree = coordinatorDegreeCode[selectedRegNoIndex]

        let enableRemoveBtn = (selectedDegree === degreeProgram + " " + batchYear) && selectedRegNoIndex !== -1
        document.getElementById("removeCoordinatorBtn").disabled =
            !(enableRemoveBtn);

        document.getElementById("assignCoordinatorBtn").disabled =
            enableRemoveBtn;
    }

    enableBtns();
</script>
