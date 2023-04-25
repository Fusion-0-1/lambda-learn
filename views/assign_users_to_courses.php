<link rel="stylesheet" href="css/assign_users.css">

<!--Success and error messages model on the bottom right to display accounts created successfully-->
<?php if($mssg == 'Success') { ?>
    <div id="mssg-modal" class="success-mssg text-justify">
        <p>User Assigned successfully.</p>
    </div>
<?php } else if($mssg == 'Exists'){?>
    <div id="mssg-modal" class="error-mssg text-justify">
        <p>User Assigned Already.</p>
    </div>
<?php }?>

<div id="file-upload-container" class="border main-container v-center flex-gap">
    <div class="flex flex-row h-justify">
        <form action="/assign_users_to_courses" method="post" class="main-container border flex flex-column flex-gap width-full" id="assign_students">
            <h3>Assign Students to courses</h3>

            <div class="flex flex-column flex-gap">
                <label>Batch year</label>
                <select class="input" id="degreeProgramSelect" name="batch_year">
                    <option value="" disabled selected hidden>Select a batch...</option>
                    <?php
                    foreach ($batch_years as $batch_year) {?>
                    <option><?php echo $batch_year ?></option>
                   <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Degree Program</label>
                <select class="input" id="courseSelect" name="degree_program" onchange="filterCourses()">
                    <option value="" disabled selected hidden>Select a degree program...</option>
                    <?php
                    foreach ($degree_programs as $degree_program) {?>
                        <option><?php echo $degree_program ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input" name="course" id="course" onchange="filterDegreeProgram()">
                    <option value="" disabled selected hidden>Select a course...</option>
                    <?php
                    foreach ($courses as $course) {?>
                        <option><?php echo $course['course_code'] . ' - ' . $course['course_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <br><button type="submit" class="edit-btn-text margin-top">Assign</button>
            </div>
        </form>


        <form action="/assign_users_to_courses" method="post" class="main-container border flex flex-column flex-gap width-full" id="assign_lecturers">
            <input type="hidden" name="assign_lecturer">
            <h3>Assign Lecturers to courses</h3>
            <?php $count = 0?>
            <div class="flex flex-column flex-gap">
                <label>Registration Number</label>
                <select class="input"  name="lecturer">
                    <option value="" disabled selected hidden>Select a lecturer...</option>
                    <?php
                    foreach ($lecturers as $lecturer) {?>
                        <option><?php echo $lecturer['reg_no']?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Lecturer Name</label>
                <input type="text" id="selectedLecturer" readonly class="input">
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input input-field" name="course">
                    <option value="" disabled selected hidden>Select a course...</option>
                    <?php
                    foreach ($courses as $course) {?>
                        <option><?php echo $course['course_code'] . ' - ' . $course['course_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <br><button class="edit-btn-text margin-top">Assign</button>
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
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, first_name, last_name, position, email, contact_number, date_joined respectively</p>
    </form>
</div>

<script>
    function filterCourses() {
        var selectedDegreeProgram = document.getElementById('courseSelect').value;
        var course = document.getElementById('course');
        course.innerHTML = '';
        <?php
        foreach ($courses as $course) { ?>
        var option = document.createElement('option');
        option.text = '<?php echo $course['course_code'] . ' - ' . $course['course_name'] ?>';
        if (option.text.startsWith(selectedDegreeProgram)) {
            course.add(option);
        }
        <?php } ?>
        for (var i = 0; i < course.options.length; i++) {
            if (course.options[i].text.startsWith(selectedDegreeProgram)) {
                course.selectedIndex = i;
                break;
            }
        }
    }

    function filterDegreeProgram() {
        var selectedCourseCode = document.getElementById('course').value;
        var degreeProgramSelect = document.getElementById('courseSelect');
        for (var i = 0; i < degreeProgramSelect.options.length; i++) {
            if (degreeProgramSelect.options[i].value === selectedCourseCode.substring(0, 2)) {
                degreeProgramSelect.options[i].selected = true;
                break;
            }
        }
    }

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
</script>


