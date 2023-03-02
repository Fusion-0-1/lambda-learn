<link rel="stylesheet" href="css/attendance_upload.css">

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="file-upload-form" class="main-container border flex flex-column"
          action="" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header"> Upload Attendance </h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex h-around v-center">
                <p> Report No </p>
                <input type="text" name="report_no" id="report_no" class="upload-input border-radius">
                <p> Date </p>
                <input type="text" name="date" id="date" class="upload-input border-radius">
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
                    <th>Date</th>
                    <th>Download</th>
                </tr>
                <tr>
                    <td>5</td>
                    <td>30.01.2023</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>23.01.2023</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>16.01.2023</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>09.01.2023</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>02.01.2023</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
            </table>
        </div>
    </div>
    <?php }?>
</div>