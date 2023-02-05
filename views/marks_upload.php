<?php
?>
<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="file-upload-form" class="border main-container flex flex-column"
          action="" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header">Data Structures and Algorithms submission marks</h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='update_existing_stu()'>Upload submission marks csv file here</p>
                <img class="upload-icon" src="./images/upload.png" alt="upload logo">
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, marks</p>
    </form>

    <div class="chart flex h-center v-center border main-container">
        <canvas id="myChart"></canvas>
    </div>
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
</script>