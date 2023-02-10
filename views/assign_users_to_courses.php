<link rel="stylesheet" href="css/assign_users.css">

<div id="file-upload-container" class="border main-container v-center flex-gap">
    <div class="flex flex-row h-justify">
        <form class="main-container border flex flex-column flex-gap width-full" id="assign_students">
            <h3>Assign Students to courses</h3>

            <div class="flex flex-column flex-gap">
                <label>Batch year</label>
                <select class="input">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Degree Program</label>
                <select class="input">
                    <option value="cs">Computer Science</option>
                    <option value="is">Information Systems</option>
                </select>
            </div>

            <div class="flex flex-column flex-gap">
                <label>Course</label>
                <select class="input">
                    <option value="scs2001">SCS2001 - Data Structures and Algorithms</option>
                    <option value="scs2002">SCS2002 - Software Engineering</option>
                    <option value="scs2003">SCS2003 - Laboratory II</option>
                    <option value="scs2004">SCS2004 - Database I</option>
                </select>
            </div>

            <div class="flex flex-column flex-gap ">
                <br><button class="edit-btn-text margin-top">Assign</button>
            </div>
        </form>


        <form class="main-container border flex flex-column flex-gap width-full" id="assign_lecturers">
            <h3>Assign Lecturers to courses</h3>

            <div class="flex flex-column flex-gap">
                <label>Registration Number</label>
                <select class="input">
                    <option value="2020lc0195">2020/LC/0195</option>
                    <option value="2019lc0010">2019/LC/0010</option>
                    <option value="2022lc0016">2022/LC/0016</option>
                    <option value="2020lc0878">2020/LC/0878</option>
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
                    <option value="scs2001">SCS2001 - Data Structures and Algorithms</option>
                    <option value="scs2002">SCS2002 - Software Engineering</option>
                    <option value="scs2003">SCS2003 - Laboratory II</option>
                    <option value="scs2004">SCS2004 - Database I</option>
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


