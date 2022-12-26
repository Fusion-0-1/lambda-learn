<link rel="stylesheet" href="css/account_creation.css">

<div id="warn-modal" class="modal modal-content error-modal-content">
    <div class="flex flex-column v-center h-center">
        <img src="./images/primary_icons/warning.svg">
        <h3 id="h3-update-student-warning" class="modal-header">Do you want to update existing students?</h3>
        <p class="modal-text">The following student are already registered. Would you like to upload?</p>
        <textarea id="warn-modal-textarea" class="modal-textarea" readonly></textarea>
        <section class="flex flex-row two-button-row">
            <button id="cancel-btn" class="dark-btn cancel-btn">Cancel</button>
            <button id="delete-btn" class="dark-btn error-btn">Continue</button>
        </section>
    </div>
</div>

<div id="student-csv-upload" class="border main-container v-center flex-gap responsive-container">
    <div class="border main-container flex flex-column">
        <h3 class="page-header">Student Accounts</h3>
        <button type="button" class="x-dark-btn">
            <div class="flex v-center">
                <p>Upload Student Details file here</p>
                <img class="upload-icon" src="./images/upload.png" alt="upload logo">
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, index_no, first_name, last_name, degree_program_code, date_joined respectively</p>
    </div>
</div>
