<link rel="stylesheet" href="css/account_creation.css">
<!--<link rel="stylesheet" href="css/profile.css">-->
<?php
function printType($type){
    if($type == 'Student') {
        echo "Student Accounts";
    } elseif ($type == 'Lecturer') {
        echo "Lecturer Accounts";
    } elseif ($type == 'Coordinator') {
        echo "Coordinator Accounts";
    } elseif ($type == 'Admin') {
        echo "Admin Accounts";
    }
}
?>
<!--Success message model on the bottom right to display accounts created successfully-->
<?php if(isset($success_mssg)) { ?>
<div id="mssg-modal" class="success-mssg text-justify">
    <p><?php printType($type); ?> created successfully.</p>
</div>
<?php } ?>

<?php if(isset($updatedUsers) || isset($invalidUsersRegNo)){ ?>
<div id="error-modal" class="modal">
    <div class="modal-content error-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/error.svg">
            <h4 id="delete-warning">Invalid Data!</h4>
            <p>Below registration numbers are <?php
                if (sizeof($updatedUsers) > 0){
                    echo "already in the database.";
                } else if (sizeof($invalidUsersRegNo) > 0) {
                    echo "invalid. CSV must follow the given format and all should be valid.
                     Registration number should follow the format: 20XX/AA/XXX.";
                    if ($type == 'Student') {
                        echo "AA = CS or IS, (Eg: 2018/CS/001)";
                    } elseif ($type == 'Lecturer') {
                        echo "AA = LC (Eg: 2018/LC/001)";
                    } elseif ($type == 'Coordinator') {
                        echo "AA = LC, (Eg: 2018/LC/001)";
                    } elseif ($type == 'Admin') {
                        echo "AA = AD, (Eg: 2018/AD/001)";
                    }
                }
            ?>
            </p>
            <p id="stu-id-list" class="text-center">
                <?php
                $print = '';
                if (sizeof($updatedUsers) > 0){
                    foreach ($updatedUsers as $student) {
                        $print .= $student->getRegNo() . ", ";
                    }
                } elseif (sizeof($invalidUsersRegNo) > 0) {
                    foreach ($invalidUsersRegNo as $student) {
                        $print .= $student . ", ";
                    }
                }
                echo substr($print, 0, -2);
                ?>
            </p>
            <button id="continue-btn" class="cancel-btn dark-btn error-btn">OK</button>
        </div>
    </div>
</div>
<?php } ?>
<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="student-csv-upload-form" class="border main-container flex flex-column" action="/upload_student_csv"
          method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" accept=".csv" hidden>
        <input type="text" name="type" value="<?php echo $type?>" hidden>
        <h3>
            <?php printType($type); ?>
        </h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='upload_stu_csv()'>Upload
                    <?php printType($type); ?>
                    Details file here</p>
                <i class="fa fa-upload upload-icon" aria-hidden="true"></i>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">
            The CSV file should include reg_no, first_name, last_name, email, personalEmail, contact_no respectively.
        </p>
    </form>

</div>

<script>
    <?php if(isset($updatedUsers) || isset($invalidUsersRegNo)){ ?>
        modal_cancel("error-modal");
    <?php } ?>

    function upload_stu_csv() {
        let input = document.getElementById('file-input-field');
        input.onchange = e => {
            let file = Array.from(input.files);
            document.getElementById('upload-file-text').innerText = 'File Name: ' + file[0]['name'];
            document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                document.getElementById('student-csv-upload-form').submit();
            });
        }
        input.click();
    }

</script>