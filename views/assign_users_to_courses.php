<link rel="stylesheet" href="css/assign_users.css">

<!--Success and error message model on the bottom right to display whether user assigned successfully-->
<?php if(isset($exists)){
    if(isset($invalid_course)){
        if(sizeof($invalid_course) > 0){?>
            <div id="mssg-modal" class="error-mssg text-justify">
                <p>Please check whether you have renamed the CSV file with the correct course code.</p>
            </div>
        <?php } elseif((isset($invalid_reg_no)) and sizeof($invalid_reg_no) > 0){?>
            <div id="mssg-modal" class="error-mssg text-justify">
                <p>Invalid registration numbers (<?php foreach ($invalid_reg_no as $regNo){
                        echo $regNo . ", " ;
                    }?>). <br>Failed to assign students.</p>
            </div>
        <?php } elseif($exists==null){?>
            <div id="mssg-modal" class="success-mssg text-justify">
                <p>Users assigned successfully</p>
            </div>
        <?php }
    } elseif($exists==null){?>
            <div id="mssg-modal" class="success-mssg text-justify">
                <p>Users assigned successfully</p>
            </div>
        <?php }
    if(sizeof($exists) > 0){?>
        <div id="mssg-modal" class="error-mssg text-justify">
            <p>Users have been assigned already</p>
        </div>
    <?php }
}
if(isset($is_deleted)) {
    if($is_deleted) { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>User deleted successfully</p>
        </div>
   <?php }  else { ?>
        <div id="mssg-modal" class="error-mssg text-justify">
        <p>User not assigned for the course</p>
        </div>
    <?php }
}?>



<div id="file-upload-container" class="border main-container v-center flex-gap">
    <div class="flex flex-row h-justify responsive-card">
        <form action="/assign_users_to_courses" method="post" name="assign_stu_form"
              class="main-container border flex flex-column flex-gap width-full" id="assign_students">
            <h3>Assign Students to courses</h3>

            <div class="flex flex-column flex-gap">
                <label>Batch year</label>
                <input class="input" type="text" value="<?php echo $year_of_coordinating?>" readonly>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Degree Program</label>
                <input class="input" type="text" value="<?php echo $degree_program?>" readonly>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input" name="course" id="course" onchange="filterDegreeProgram()" required>
                    <option value="" disabled selected hidden>Select a course...</option>
                    <?php
                    $topicCounts = array();
                    foreach ($courses as $course) {
                        $topicCounts[$course['course_code']] = \app\model\Course::getTopicCount($course['course_code']);
                        if(\app\model\Course::getTopicCount($course['course_code']) > 0){?>
                        <option><?php echo $course['course_code'] . ' - ' . $course['course_name']?></option>
                    <?php }
                    }?>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <br><button type="submit" class="edit-btn-text margin-top">Assign</button>
            </div>
        </form>

        <form action="/assign_users_to_courses" method="post"
              class="main-container border flex flex-column flex-gap width-full" id="assign_lecturers">
            <input type="hidden" name="assign_lecturer">
            <h3>Assign Lecturers to courses</h3>
            <?php $count = 0?>
            <div class="flex flex-column flex-gap">
                <label>Registration Number</label>
                <select class="input"  name="lecturer" required>
                    <option value="" disabled selected hidden>Select a lecturer...</option>
                    <?php
                    foreach ($lecturers as $lecturer) {?>
                        <option><?php echo $lecturer['reg_no']?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Lecturer Name</label>
                <input type="text" id="selectedLecturer" readonly class="input" required>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input input-field" name="course" required>
                    <option value="" disabled selected hidden>Select a course...</option>
                    <?php
                    foreach ($courses as $course) {?>
                        <option><?php echo $course['course_code'] . ' - ' . $course['course_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <div class="flex flex-row flex-gap">
                    <br><button class="edit-btn-text margin-top" name="assign" value="assign">Assign</button>
                    <button class="edit-btn-text margin-top" name="delete" value="assign">Delete</button>
                </div>
            </div>

        </form>
    </div>

    <form id="file-upload-form" class="main-container border flex flex-column"
          action="/upload_student_course_csv" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header">Assign Students to Courses</h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='update_existing_stu()'>Upload student courses details file here</p>
                <i class="fa fa-upload upload-icon" aria-hidden="true"></i>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">
            The CSV file should be renamed with the course code which you are going to assign users.<br>
            The CSV file should include only the registration numbers of the students to be assigned.
            Every new registration number should start from a new line, and it should be in the first column.
        </p>
    </form>
</div>

<script>
    var lecturers = <?php echo json_encode($lecturers); ?>;
    function onLecturerSelectChange() {
        var selectElement = document.querySelector('select[name="lecturer"]');
        var selectedLecturerRegNo = selectElement.options[selectElement.selectedIndex].text;
        var selectedLecturerName = '';
        for (var i = 0; i < lecturers.length; i++) {
            if (lecturers[i]['reg_no'] === selectedLecturerRegNo) {
                selectedLecturerName = lecturers[i]['first_name'] +  " " + lecturers[i]['last_name'];
                break;
            }
        }
        document.getElementById('selectedLecturer').value = selectedLecturerName;
    }
    document.querySelector('select[name="lecturer"]').onchange = onLecturerSelectChange;

    function update_existing_stu() {
        let input = document.getElementById('file-input-field');
        input.onchange = e => {
            let file = Array.from(input.files);
            document.getElementById('upload-file-text').innerText = 'File Name: ' + file[0]['name'];
            document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                document.getElementById('file-upload-form').submit();
            });
        }
        input.click();
    }
</script>


