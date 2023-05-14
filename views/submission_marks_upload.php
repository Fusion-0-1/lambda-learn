<link rel="stylesheet" href="css/marks_upload.css">

<?php if(isset($invalid_user)){
    if($invalid_user){?>
        <div id="mssg-modal" class="error-mssg text-justify">
            <p>The CSV file contains invalid Registration Numbers or Users Not Assigned to the Course.</p>
        </div>
    <?php } else { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>Marks uploaded successfully.</p>
        </div>
    <?php }
} ?>

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="file-upload-form" class="main-container border flex flex-column"
          action="/submission_marks_upload" method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <input type="text" name="course_code" value="<?php echo $course->getCourseCode();?>" hidden>
        <input type="text" name="submission_id" value="<?php echo $submission_id;?>" hidden>
        <h3><?php echo $course->getCourseName()?></h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='update_exam_marks()'>Upload exam marks csv file here</p>
                <i class="fa fa-upload upload-icon" aria-hidden="true"></i>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, marks.</p>
    </form>

    <div class="main-container border">
        <div class="chart flex h-center v-center main-container">
            <canvas id="course_progress_chart"></canvas>
        </div>

        <?php if ($_SESSION['user-role'] == 'Coordinator') {?>
            <div class="main-container border">
                <div>
                    <table class="download-table">
                        <tr>
                            <th>Year</th>
                            <th>Download</th>
                        </tr>
                        <?php
                        $path = 'User Uploads/Exam marks/' . $course->getCourseCode();
                        $files = scandir($path);
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..' && is_file($path . '/' . $file)) {
                                echo "<tr>";
                                echo "<td>" . $file . "</td>";
                                echo "<td><a href='" . $path . '/' . $file . "' target='blank'
                                    <i class=\"fa fa-download download-icon\" aria-hidden=\"true\"></i>
                                    </a>
                                    </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        <?php }?>
    </div>


    <script>
        var course_progress_chart = document.getElementById("course_progress_chart").getContext("2d");
        var xValues = [10,20,30,40,50,60,70,80,90,100];

        var chart = new Chart(course_progress_chart, {
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

        function update_exam_marks() {
            let input = document.getElementById('file-input-field');
            input.onchange = e => {
                let file = Array.from(input.files);
                document.getElementById('upload-file-text').innerText = 'File Name: ' + file[0]['name'];
                document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                    document.getElementById('file-upload-form').submit();
                });
            }
            input.click();
        }
    </script>