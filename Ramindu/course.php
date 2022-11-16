<?php
session_start();
include('db.php');
include('navbar.php');
?>
    <link href="css/courses.css" rel="stylesheet">
    </head>
    <body>
    <div class="main-container outer border flex flex-column v-center h-center">
        <div class="main-container inner border flex flex-column h-center">
            <div class="heading">
                <h1>Course Create</h1>
            </div>
            <form action="course-create.php" method="GET">
                <p>Course Code</p>
                <p>Course Name</p>
                <p></p>
                <label>
                    <input id="input-create-course-code" class="input" type="text" name="course_code" placeholder="Course Code" required/>
                </label>
                <label>
                    <input id="input-create-course-name" class="input" type="text" name="course_name" placeholder="Course Name" required/>
                </label>
                <button class="dark-btn" type="submit" onclick="return course_validate(document.getElementById('input-create-course-code').value)" name="create">Create</button>
            </form>
            <?php
            if(isset($_GET['error'])) {
                echo "<h2 class='error error-bg text-center'>Error: Course Code already exists</h2>";
            }
            ?>
        </div>
        <div class="main-container inner border flex flex-column v-center">
            <h2 id="delete-success-message" class='success success-bg text-center hide'></h2>
            <div id="edit-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form action="course-edit.php" method="GET">
                        <p>Course Code</p>
                        <p>Course Name</p>
                        <p></p>
                        <label>
                            <input id="input-edit-course-code" class="input" type="text" name="course_code" placeholder="Course Code" required/>
                        </label>
                        <label>
                            <input id="input-edit-course-name" class="input" type="text" name="course_name" placeholder="Course Name" required/>
                        </label>
                        <button id="edit-save-btn" class="dark-btn" type="submit" onclick="return course_validate(document.getElementById('input-edit-course-code').value)" name="edit">Save</button>
                    </form>
                </div>
            </div>
            <table id="course-table" cellpadding="0" cellspacing="0">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th></th>
                </tr>
                <?php
                $sql = "SELECT * FROM Courses";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['course_code'] . "</td>";
                    echo "<td>" . $row['course_name'] . "</td>";
                    echo "<td><button class='error-btn error-btn-icon' onclick='delete_course(this, \"" . $row['course_code'] . "\")'> <i class='fa fa-trash' aria-hidden='true'></i> </button></td>";
                    echo "<td><button class='edit-btn edit-btn-icon' onclick='edit_course(\"" . $row['course_code'] . "\",\"". $row['course_name'] ."\")'> <i class='fa fa-pencil' aria-hidden='true'></i> </button></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <script>
        function course_validate(course_code) {
            if (course_code.length !== 7) {
                alert("Course code must be 7 characters long");
                return false;
            }
            return true;
        }

        function delete_course(btn, course_code) {
            if (confirm("Are you sure you want to delete " + course_code + "?")) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("delete-success-message").innerHTML = this.responseText + " has been deleted";
                        document.getElementById("delete-success-message").style.display = "block";
                        const row = btn.parentNode.parentNode;
                        row.parentNode.removeChild(row);
                    }
                }
                xmlhttp.open("DELETE", "course-delete.php?course_code=" + course_code, true);
                xmlhttp.send();
            }
        }
        function edit_course(course_code, course_name) {
            document.getElementById("input-edit-course-code").value = course_code;
            document.getElementById("input-edit-course-name").value = course_name;

            const modal = document.getElementById("edit-modal");
            modal.style.display = "block";
            const span = document.getElementsByClassName("close")[0];
            span.onclick = function () {
                modal.style.display = "none";
            };
            window.onclick = function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };

            const edit_save_btn = document.getElemenxtById("edit-save-btn");
            edit_save_btn.onclick = function () {
                window.location.href = "course-edit.php?course_code=" + course_code + "&course_name=" + course_name;
            }
        }
    </script>
    </body>

<?php
include('footer.html');
?>