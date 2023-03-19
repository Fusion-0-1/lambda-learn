<link rel="stylesheet" href="css/attendance_upload.css">

<!--Success message model on the bottom right to display attendance updated successfully-->
<?php if(isset($success_mssg)) { ?>
    <div id="mssg-modal" class="success-mssg text-justify">
        <p>Attendance updated successfully.</p>
    </div>
<?php } ?>
<?php if(isset($errors)){ ?>
    <div id="error-modal" class="modal">
        <div class="modal-content error-modal-content">
            <div class="flex flex-column v-center h-center">
                <img src="./images/primary_icons/error.svg">
                <h4 id="delete-warning">Invalid Data!</h4>
                <?php if (sizeof($errors) > 0) { ?>
                    <p>Below registration numbers/course codes are invalid. CSV must follow the given format and all
                        should be valid i.e. should be existed in the system. Registration number should follow the
                        format: 20XX/AA/XXX. Course code should follow the format: AA XXX. Example: CS 2001.
                    </p>
                    <p id="stu-id-list" class="text-center">
                        <?php
                        $print = '';
                        foreach ($errors as $student) {
                            $print .= $student . ", ";
                        }
                        echo substr($print, 0, -2);
                        ?>
                    </p>
                <?php } else { ?>
                    <p>Course code is invalid. CSV must follow the given format and all should be valid.
                        Course code should follow the format: AA XXX. Example: CS 2001
                    </p>
                <?php } ?>
                <button id="continue-btn" class="cancel-btn dark-btn error-btn">OK</button>
            </div>
        </div>
    </div>
<?php } ?>

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="file-upload-form" class="main-container border flex flex-column"
          action="/attendance_upload" method="post" enctype="multipart/form-data">
        <h3> Upload Attendance </h3>
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex h-around v-center">
                <p> Report </p>
                <input type="text" name="report_no" id="report_name" onclick="upload_attendance_csv()"
                       class="upload-input border-radius text-center" value="Upload">
                <p> Date </p>
                <input type="date" name="date" id="date-picker" class="upload-input border-radius text-center">
                <p><i class="fa fa-upload upload-icon" aria-hidden="true"></i></p>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, index_no and course_code respectively</p>
    </form>

    <div class="main-container border">

        <?php if ($_SESSION['user-role'] == 'Admin') {?>
        <div>
            <table class="download-table">
                <tr>
                    <th>Report No</th>
                    <th>File Name</th>
                    <th>Date</th>
                    <th>Download</th>
                </tr>
                <?php
                foreach ($csvFiles as $file) {
                    echo "<tr>";
                        echo "<td>" . $file['report_id'] . "</td>";
                        echo "<td>" . $file['title'] . "</td>";
                        echo "<td>" . $file['report_date'] . "</td>";
                        echo "<td><a href='" . $file['path'] . "' target='blank'
                                    <i class=\"fa fa-download download-icon\" aria-hidden=\"true\"></i>
                                    </a>
                                    </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <?php }?>
</div>


<script>
    <?php if(isset($errors)){ ?>
    modal_cancel("error-modal");
    <?php } ?>

    document.getElementById('date-picker').valueAsDate = new Date();

    function upload_attendance_csv() {
        let input = document.getElementById('file-input-field');
        input.onchange = e => {
            let file = Array.from(input.files);
            document.getElementById('report_name').value = file[0]['name'];
            document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                document.getElementById('file-upload-form').submit();
            });
        }
        input.click();
    }
</script>