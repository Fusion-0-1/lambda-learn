<link href="css/course/course_creation.css" rel="stylesheet">
</head>
<body>
<div class="main-container outer border flex flex-column v-center h-center">
    <div class="main-container inner border flex flex-column h-center">
        <div class="heading">
            <h3>Course Create</h3>
        </div>
        <form action="" method="GET" class="course_create_form flex flex-row">
            <label class="flex flex-column">
                <p>Course Code</p>
                <input id="input-create-course-code" class="input" type="text" name="course_code" placeholder="Course Code" required/>
            </label>
            <label class="flex flex-column">
                <p>Course Name</p>
                <input id="input-create-course-name" class="input" type="text" name="course_name" placeholder="Course Name" required/>
            </label>
            <label class="flex flex-column h-end" id="create_course">
                <button class="dark-btn" type="submit" onclick="return course_validate(document.getElementById('input-create-course-code').value)" name="create">Create</button>
            </label>
        </form>
    </div>
    <div class="main-container inner border">
        <h3>Courses</h3>
        <div class="overflow-x grid grid-table">
                <table class="text-column">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                    </tr>
                    <tr>
                        <td class="text-center">SCS2202</td>
                        <td>Group project I</td>
                    </tr>
                    <tr>
                        <td class="text-center">SCS2209</td>
                        <td>Database II</td>
                    </tr>
                    <tr>
                        <td class="text-center">SCS2210</td>
                        <td>Discrete Mathematics II</td>
                    </tr>
                    <tr>
                        <td class="text-center">SCS2211</td>
                        <td>Laboratory II</td>
                    </tr>
                </table>
                <table class="button-column">
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><button class='error-btn error-btn-icon' onclick='delete_course(this, "SCS2209")'> <i class='fa fa-trash' aria-hidden='true'></i> </button></td>
                        <td><button class='edit-btn edit-btn-icon' onclick='edit_course("SCS2209","Database II")'> <i class='fa fa-pencil' aria-hidden='true'></i> </button></td>
                    </tr>
                    <tr>
                        <td><button class='error-btn error-btn-icon' onclick='delete_course(this, "SCS2210")'> <i class='fa fa-trash' aria-hidden='true'></i> </button></td>
                        <td><button class='edit-btn edit-btn-icon' onclick='edit_course("Discrete Mathematics II", "SCS2210")'> <i class='fa fa-pencil' aria-hidden='true'></i> </button></td>
                    </tr>
                    <tr>
                        <td><button class='error-btn error-btn-icon' onclick='delete_course(this, "SCS2211")'> <i class='fa fa-trash' aria-hidden='true'></i> </button></td>
                        <td><button class='edit-btn edit-btn-icon' onclick='edit_course("SCS2211", "Laboratory II")'> <i class='fa fa-pencil' aria-hidden='true'></i> </button></td>
                    </tr>
                    <tr>
                        <td><button class='error-btn error-btn-icon' onclick='delete_course(this, "SCS2211")'> <i class='fa fa-trash' aria-hidden='true'></i> </button></td>
                        <td><button class='edit-btn edit-btn-icon' onclick='edit_course("SCS2211", "Laboratory II")'> <i class='fa fa-pencil' aria-hidden='true'></i> </button></td>
                    </tr>
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
        <form action="" method="GET">
            <div class="course_create_form flex flex-row">
                <label class="flex flex-column">
                    <p>Course Code</p>
                    <input id="input-edit-course-code" class="input" type="text" name="course_code" placeholder="Course Code" required/>
                </label>
                <label class="flex flex-column">
                    <p>Course Name</p>
                    <input id="input-edit-course-name" class="input" type="text" name="course_name" placeholder="Course Name" required/>
                </label>
            </div>
            <div class="flex h-center">
                <div class="flex flex-row two-button-row">
                    <label class="flex flex-column h-center">
                        <button id="cancel-btn-edit" class="cancel-btn btn-border-blue" type="button" name="create">Cancel</button>
                    </label>
                    <label class="flex flex-column h-center">
                        <button class="dark-btn" type="submit" onclick="return course_validate(document.getElementById('input-edit-course-code').value)" name="create">Create</button>
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="delete-modal" class="modal" hidden>
    <div class="modal-content error-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/error.svg">
            <h4 id="delete-warning" class="modal-header">Are you sure?</h4>
            <p class="modal-text">Once you delete a course, you cannot undo the process</p>
            <section class="flex flex-row two-button-row">
                <button class="dark-btn cancel-btn">Cancel</button>
                <button id="delete-btn" class="dark-btn error-btn">Delete</button>
            </section>
        </div>
    </div>
</div>

<div id="warn-modal" class="modal" hidden>
    <div class="modal-content warn-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/warning.svg">
            <h4 id="delete-warning">Invalid Course Code</h4>
            <div>
                <p>Course code should follow below format,</p>
                <ul>
                    <li>Must contain 7 characters.</li>
                    <li>Should starts with 3 letters (Non-symbolic).</li>
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
<script type="text/javascript" src="./js/validation.js"></script>
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

        const modal = document.getElementById("delete-modal");
        modal.hidden = false;

        // const delete_btn = document.getElementById("delete-btn");
        // delete_btn.onclick = function () {
        //     var xmlhttp = new XMLHttpRequest();
        //     xmlhttp.onreadystatechange = function() {
        //         if (this.readyState === 4 && this.status === 200) {
        //             document.getElementById("delete-success-message").innerHTML = this.responseText + " has been deleted";
        //             document.getElementById("delete-success-message").style.display = "block";
        //             const row = btn.parentNode.parentNode;
        //             row.parentNode.removeChild(row);
        //         }
        //     }
        //     xmlhttp.open("DELETE", "course-delete.php?course_code=" + course_code, true);
        //     xmlhttp.send();
        //     modal.style.display = "none";
        // }
    }

    function edit_course(course_code, course_name) {
        document.getElementById("input-edit-course-code").value = course_code;
        document.getElementById("input-edit-course-name").value = course_name;

        const modal = document.getElementById("edit-modal");
        modal.hidden = false;

        // const edit_save_btn = document.getElementById("edit-save-btn");
        // edit_save_btn.onclick = function () {
        //     window.location.href = "course-edit.php?course_code=" + course_code + "&course_name=" + course_name;
        // }
    }
</script>
</body>