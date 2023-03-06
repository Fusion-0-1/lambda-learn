<link rel="stylesheet" href="css/attendance_upload.css">

<div class="border main-container v-center flex-gap responsive-container">

    <h3> Utilization Reports </h3>

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
    <?php }?>
</div>