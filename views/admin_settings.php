<link rel="stylesheet" href="css/assign_users.css">

<!--Success and error message model on the bottom right to display whether user assigned successfully-->
<?php use app\model\User\Lecturer;

if(isset($msg)){
    if(isset($is_assigned_coordinator)){?>
        <div id="mssg-modal" class="<?php if ($is_assigned_coordinator) echo "success-mssg"; else echo "error-mssg";?> text-justify">
            <p><?php echo $msg ?></p>
        </div>
    <?php } elseif(isset($is_settings_setup)){?>
        <div id="mssg-modal" class="<?php if ($is_settings_setup) echo "success-mssg"; else echo "error-mssg";?> text-justify">
            <p><?php echo $msg ?></p>
        </div>
    <?php }
}?>


<div id="file-upload-container" class="border main-container v-center flex-gap">
    <div class="flex flex-row h-justify responsive-card">
        <form action="/assign_coordinator" method="post" name="assign_coordinator_form"
              class="main-container border flex flex-column flex-gap width-full" id="assign_coordinator">
            <h3>Assign Coordinator</h3>

            <div class="flex flex-column flex-gap">
                <label>Lecturer</label>
                <label for="lecturer_regno_name"></label>
                <select class="input" name="lecturer_regno_name" required>
                    <option value="" disabled selected hidden>Select a batch...</option>
                    <?php
                    foreach ($lecturers as $lecturer) {
                        echo "<option>" . $lecturer['reg_no'] . "-" .
                            Lecturer::getLecturerName($lecturer['reg_no']) . "</option>";
                    } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Batch year</label>
                <label for="batch_year"></label><select class="input" name="batch_year" required>
                    <option value="" disabled selected hidden>Select a batch...</option>
                    <?php
                    foreach($batch_years as $year) { ?>
                    <option><?php echo $year?></option>
                   <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Degree Program</label>
                <select class="input" name="degree_program" onchange="filterCourses()" required>
                    <option value="" disabled selected hidden>Select a degree program...</option>
                    <?php
                    foreach($degree_programs as $degree_program) {
                        echo "<option>$degree_program</option>";
                    } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <br><button type="submit" class="edit-btn-text margin-top">Assign</button>
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
</div>


