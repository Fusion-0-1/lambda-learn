<link rel="stylesheet" href="css/assign_users.css">

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
                <select class="input" id="courseSelect" name="degree_program">
                    <option value="" disabled selected hidden>Select a degree program...</option>
                    <?php
                    foreach ($degree_programs as $degree_program) {?>
                        <option><?php echo $degree_program ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input" name="course">
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
            <h3>Assign Lecturers to courses</h3>

            <div class="flex flex-column flex-gap">
                <label>Registration Number</label>
                <select class="input">
                    <?php
                    foreach ($lecturers as $lecturer) {?>
                        <option><?php echo $lecturer ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Year</label>
                <select class="input">
                    <option value="1">Year 1</option>
                    <option value="2">Year 2</option>
                    <option value="3">Year 3</option>
                    <option value="4">Year 4</option>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input">
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
          action="" method="post" enctype="multipart/form-data">
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


