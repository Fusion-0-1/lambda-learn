<link rel="stylesheet" href="css/account_creation.css">

<!-- TODO 1: Create invalid user modal and error prompt
    TODO 2: Update user continue click implementation
-->

<div id="existing-stu-modal" class="modal" <?php if(!isset($updatedUsers)) echo "hidden";?>>
    <div class="modal-content warn-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/warning.svg">
            <h4 id="delete-warning">Do you want to update existing students?</h4>
            <p>Following student are already registered. Would you like to continue?</p>
            <p id="stu-id-list" class="text-center">
                <?php
                $print = '';
                foreach ($updatedUsers as $student) {
                    $print .= $student->getRegNo() . ", ";
                }
                echo substr($print, 0, -2);
                ?>
            </p>
            <section class="flex flex-row two-button-row">
                <button id="cancel-btn" class="dark-btn cancel-btn">Cancel</button>
                <button id="continue-btn" class="dark-btn warn-continue-btn">Continue</button>
            </section>
        </div>
    </div>
</div>

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="student-csv-upload-form" class="border main-container flex flex-column" action="/upload_student_csv" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header">Student Accounts</h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='update_existing_stu()'>Upload Student Details file here</p>
                <img class="upload-icon" src="./images/upload.png" alt="upload logo">
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, index_no, first_name, last_name, degree_program_code, date_joined respectively</p>
    </form>
</div>

<script>
    if (document.getElementById('existing-stu-modal').hidden === false) {
        const modal = document.getElementById("existing-stu-modal");

        const cancel_btn = document.getElementById("cancel-btn");
        cancel_btn.onclick = function () {
            modal.hidden = true;
        };

        const continue_btn = document.getElementById("continue-btn");
        continue_btn.onclick = function () {
            modal.hidden = true;
        }
    }

    function update_existing_stu() {
        let input = document.getElementById('file-input-field');
        input.onchange = e => {
            let file = Array.from(input.files);
            console.log(file);
            document.getElementById('upload-file-text').innerText = 'File Name: ' + file[0]['name'];
            document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                document.getElementById('student-csv-upload-form').submit();
            });
        }
        input.click();
    }
</script>