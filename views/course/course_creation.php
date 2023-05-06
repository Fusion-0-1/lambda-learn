<link href="css/course/course_creation.css" rel="stylesheet">
<script type="text/javascript" src="./js/validation.js"></script>

<!--success and error messages-->
<?php if(isset($course_insert)) {
    if($course_insert){?>
    <div id="mssg-modal" class="success-mssg text-justify">
        <p>Course Created successfully.</p>
    </div>
    <?php } else { ?>
    <div id="mssg-modal" class="error-mssg text-justify">
        <p>The course exists.</p>
    </div>
<?php }
    } elseif(isset($course_update)) {
    if($course_update){?>
    <div id="mssg-modal" class="success-mssg text-justify">
        <p>Course updated successfully.</p>
    </div>
    <?php } else { ?>
    <div id="mssg-modal" class="error-mssg text-justify">
        <p>Failed to update course.</p>
    </div>
<?php }
    } elseif(isset($course_delete)) {
    if($course_delete){?>
    <div id="mssg-modal" class="success-mssg text-justify">
        <p>Course deleted successfully.</p>
    </div>
    <?php } else { ?>
    <div id="mssg-modal" class="error-mssg text-justify">
        <p>Failed to delete course.</p>
    </div>
<?php }
    }?>

<div class="main-container outer border flex flex-column v-center h-center">
    <div class="main-container inner border flex flex-column h-center">
        <div class="heading">
            <h3>Course Create</h3>
        </div>
        <h4 class="csv-header-text">Course Code Format:</h4>
        <p class="csv-header-format flex v-center h-center">
            The course code format consists of six characters starting with two uppercase letters followed by four digits.
            The first two letters indicate the degree program (e.g., 'CS' for Computer Science), while the remaining four
            digits represent the year, semester, and course number. Specifically, the first digit of the four-digit code
            denotes the year, the second digit represents the semester, and the last two digits indicate the course number.
            For example, CS 2101 denotes a second-year first-semester course in the Computer Science program.
        </p>
        <br>
        <form action="create_course" method="POST" class="course-create-form flex flex-row">
            <label class="flex flex-column">
                <p>Course Code</p>
                <input id="input-create-course-code" class="input" type="text" name="course_code"
                       placeholder="Course Code" required/>
            </label>
            <label class="flex flex-column">
                <p>Course Name</p>
                <input id="input-create-course-name" class="input" type="text" name="course_name"
                       placeholder="Course Name" required/>
            </label>
            <label class="flex flex-column">
                <p>Course Type</p>
                <select class="input drop-down" name="course_type" id="course-type">
                    <option>Optional</option>
                    <option>Compulsory</option>
                </select>
            </label>
            <label class="flex flex-column h-end" id="create-course">
                <button class="dark-btn" type="submit"
                        onclick="return course_validate(document.getElementById('input-create-course-code').value)">
                    Create
                </button>
            </label>
        </form>
    </div>
    <div class="main-container inner border">
        <h3>Courses</h3>
        <p class="csv-header-format flex v-center h-center">
            Please note that courses can only be deleted if they have not been initialized by the lecturer. If you
            attempt to delete a course that has already been initialized, you will need to wait until the end of the
            semester when the lecturer can reset the course before you can delete it.
        </p>
        <div class="overflow-x grid grid-table">
                <table class="text-column">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                    </tr>
                    <?php foreach ($courses as $course) {
                        if(date('Y-m-d') == $course['date_created']){?>
                            <tr class="tr-new-course">
                                <td class="text-center"><?php echo $course['course_code']?></td>
                                <td><?php echo $course['course_name']?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center"><?php echo $course['course_code']?></td>
                                <td><?php echo $course['course_name']?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
                <table class="button-column">
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($courses as $course) { ?>
                        <tr>
                            <td>
                                <?php if(\app\model\Course::getTopicCount($course['course_code'])==0){?>
                                <button class='error-btn error-btn-icon'
                                        onclick='delete_course(this, "<?php echo $course['course_code']?>")'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>
                                <?php } else {?>
                                <button class='error-btn error-btn-icon'  id="delete-course" disabled>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>
                                <?php }?>
                            </td>
                            <td>
                                <button class='edit-btn edit-btn-icon'
                                        onclick='edit_course("<?php echo $course['course_code']?>","<?php echo $course['course_name']?>")'>
                                    <i class='fa fa-pencil' aria-hidden='true'></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

        </div>
    </div>
</div>
<!--  Modals-->
<div id="edit-modal" class="modal" hidden>
    <div class="modal-content flex flex-column h-center">
            <div class="heading">
                <h3>Course Create</h3>
            </div>
        <form action="edit_course" method="POST">
            <div class="course-create-form flex flex-row">
                <label class="flex flex-column">
                    <p>Course Code</p>
                    <input id="input-edit-course-code" class="input" type="text" name="course_code" readonly/>
                </label>
                <label class="flex flex-column">
                    <p>Course Name</p>
                    <input id="input-edit-course-name" class="input" type="text" name="course_name"/>
                </label>
            </div>
            <div class="flex h-center">
                <div class="flex flex-row two-button-row">
                    <label class="flex flex-column h-center">
                        <button id="cancel-btn-edit" class="cancel-btn btn-border-blue" type="button" name="create">
                            Cancel
                        </button>
                    </label>
                    <label class="flex flex-column h-center">
                        <button class="dark-btn" type="submit">Update</button>
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="delete-modal" class="modal" hidden>
    <form action="delete_course" method="POST" id="delete_form">
        <div class="modal-content error-modal-content">
            <div class="flex flex-column v-center h-center">
                <img src="./images/primary_icons/error.svg">
                <h4 id="delete-warning" class="modal-header">Are you sure?</h4>
                <p class="modal-text">Once you delete a course, you cannot undo the process</p>
                <section class="flex flex-row two-button-row">
                    <button class="dark-btn cancel-btn">Cancel</button>
                    <button type="submit" id="delete-btn" class="dark-btn error-btn">Delete</button>
                </section>
            </div>
        </div>
    </form>
</div>

<div id="warn-modal" class="modal" hidden>
    <div class="modal-content warn-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/warning.svg">
            <h4 id="delete-warning">Invalid Course Code</h4>
            <div>
                <p>Course code should follow below format,</p>
                <ul>
                    <li>Must contain 6 characters.</li>
                    <li>Should starts with 2 letters (Non-symbolic).</li>
                    <li>Should ends with 4 digits.</li>
                </ul>
            </div>
            <section class="flex flex-row two-button-row">
                <button id="continue-btn" class="dark-btn cancel-btn warn-continue-btn">OK</button>
            </section>
        </div>
    </div>
</div>

<!--  Scripts  -->
<script>
    modal_cancel("edit-modal");
    modal_cancel("delete-modal");
    modal_cancel("warn-modal");

    function course_validate(course_code) {
        if (!validate_course_code(course_code)) {
            const modal = document.getElementById("warn-modal");
            modal.hidden = false;
            return false;
        }
        return true;
    }

    function delete_course(btn, course_code) {
        document.getElementById("delete-warning").innerHTML = "Are you sure you want to delete " + course_code + " course? ";

        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "course_code")
        input.setAttribute("value", course_code);
        document.getElementById('delete_form').appendChild(input);

        const modal = document.getElementById("delete-modal");
        modal.hidden = false;
    }

    function edit_course(course_code, course_name) {
        document.getElementById("input-edit-course-code").value = course_code;
        document.getElementById("input-edit-course-name").value = course_name;

        const modal = document.getElementById("edit-modal");
        modal.hidden = false;
    }
</script>