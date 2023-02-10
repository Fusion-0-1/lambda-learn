<link rel="stylesheet" href="css/marks_upload.css">

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="file-upload-form" class="main-container border flex flex-column"
          action="" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header">Data Structures and Algorithms Submission Marks</h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='update_existing_stu()'>Upload submission marks csv file here</p>
                <i class="fa fa-upload upload-icon" aria-hidden="true"></i>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, marks</p>
    </form>

    <div class="main-container border">
        <div class="chart flex h-center v-center main-container">
            <canvas id="course_progress_chart"></canvas>
        </div>

        <?php if ($_SESSION['user-role'] == 'Coordinator') {?>
        <div class="download-table overflow-x">
            <table class="main-container overflow-x">
                <tr>
                    <th>Year</th>
                    <th>Date</th>
                    <th>Download</th>
                </tr>
                <tr>
                    <td>2</td>
                    <td>08.10.2022</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>08.03.2022</td>
                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>
                </tr>
            </table>
        </div>
    </div>
    <?php }?>
</div>


<script>
    var xValues = [10,20,30,40,50,60,70,80,90,100];

    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                data: [3,7,12,15,16,14,12,8,7,2,1],
                borderColor: "blue",
                fill: false
            }]
        },
        options: {
            legend: {display: false},
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of students'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Assignment Marks'
                    }
                }]
            }
        }
    });

    // If accessing using Mobile-S (320px) device, then the graph
    // will not display due to size of the screen width
    if(window.innerWidth <= 320) {
        document.getElementsByClassName("chart")[0].innerHTML =
            "<p>Please Rotate your mobile phone and refresh the page.</p>"
    }
</script>