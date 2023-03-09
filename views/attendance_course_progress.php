<link rel="stylesheet" href="css/attendance_course_progress.css">

<div class="main-container border">
    <div class="flex flex-row h-center">
        <h3>Student Attendance</h3>
        <div class="selector flex flex-row v-center">
            <p>Academic Year : </p>
            <select>
                <option value="1">Year 1</option>
                <option value="2">Year 2</option>
                <option value="3">Year 3</option>
                <option value="4">Year 4</option>
            </select>
        </div>
    </div>
    <div class="main-container border overflow-x">
        <div class="chart flex h-center v-center main-container">
            <canvas id="attendance_chart"></canvas>
        </div>
    </div>

    <div class="flex flex-row h-center">
        <h3 class="page-header">Course Progress</h3>
        <div></div>
    </div>
    <div class="main-container border">
        <canvas id="course_progress_chart"></canvas>
    </div>
</div>

<script>
    var randomDataset = function(){
        var data = [];
        for (var i = 0; i < 22; i++) {
            data.push(Math.floor(Math.random() * (700 - 200 + 1) + 200));
        }
        return data;
    }

    function createLinearGradient(ctx, stops) {
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        for (var i = 0; i < stops.length; i++) {
            gradient.addColorStop(stops[i].offset, stops[i].color);
        }
        return gradient;
    }

    // ----------------- Course Progress Chart -----------------
    var ctx = document.getElementById("attendance_chart").getContext('2d');
    var attendance_chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                "Week 1", "Week 2", "Week 3", "Week 4", "Week 5", "Week 6", "Week 7", "Week 8", "Week 9",
                "Week 10", "Week 11", "Week 12", "Week 13", "Week 14", "Week 15", "Week 16", "Week 17", "Week 18",
                "Week 19", "Week 20", "Week 21", "Week 22"
            ],
            datasets: [{
                label: 'SCS2201',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2202',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2203',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2204',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2205',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2206',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }, {
                label: 'SCS2207',
                fill: false,
                data: randomDataset(),
                borderColor: randomColour(),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                yAxes: [{
                    ticks: {
                        max: 700,
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Number of Students Present"
                    },
                    grid: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Days of the month"
                    }
                }],
            }
        }
    });

    // ----------------- Attendance Chart -----------------
    var course_progress_chart = document.getElementById("course_progress_chart").getContext("2d");
    var myChart = new Chart(course_progress_chart, {
        type: 'bar',
        data: {
            labels: ["SCS 2201", "SCS 2202", "SCS 2203", "SCS 2204", "SCS 2205", "SCS 2206", "SCS 2207"],
            datasets: [{
                label: 'Course Progress Percentage',
                data: [
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100),
                    Math.floor(Math.random() * 100)
                ],
                backgroundColor: [
                    createLinearGradient(ctx, [
                        {offset: 0, color: '#2AB514'},
                        {offset: 1, color: '#8BB514'}
                    ]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                    createLinearGradient(ctx, [{offset: 0, color: '#2AB514'},{offset: 1, color: '#8BB514'}]),
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 100,
                        stepSize: 10
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Course Progress Percentage'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Courses'
                    }
                }]
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            }
        }
    });


    // If accessing using Mobile-S (320px) device, then the graph
    // will not display due to size of the screen width
    if(window.innerWidth < 768) {
        document.getElementsByClassName("chart")[0].innerHTML =
            "<p>Chart is too large. Cannot Display in mobile view.</p>"
    }
</script>
