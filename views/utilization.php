<link rel="stylesheet" href="css/utilization.css">

<div class="border main-container v-center flex-gap responsive-container">

    <h3> Utilization Graphs </h3>

        <?php if ($_SESSION['user-role'] == 'Admin') {?>

        <div class="flex flex-column">
            <div class="flex flex-row">
                <div class="chart cpu_line_chart main-container">
                    <canvas id="cpu_line_chart"></canvas>
                </div>
                <div class="chart process_count_chart main-container">
                    <canvas id="process_count_chart"></canvas>
                </div>
            </div>
            <div class="chart memory_chart main-container">
                <canvas id="memory_chart"></canvas>
            </div>
        </div>

<!--        <div>-->
<!--            <table class="download-table">-->
<!--                <tr>-->
<!--                    <th>Report No</th>-->
<!--                    <th>Date</th>-->
<!--                    <th>Download</th>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>5</td>-->
<!--                    <td>30.01.2023</td>-->
<!--                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>4</td>-->
<!--                    <td>23.01.2023</td>-->
<!--                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>3</td>-->
<!--                    <td>16.01.2023</td>-->
<!--                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>2</td>-->
<!--                    <td>09.01.2023</td>-->
<!--                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>1</td>-->
<!--                    <td>02.01.2023</td>-->
<!--                    <td><i class="fa fa-download download-icon" aria-hidden="true"></i></td>-->
<!--                </tr>-->
<!--            </table>-->
<!--        </div>-->

        <script>
            // If accessing using Mobile-S (320px) device, then the graph
            // will not display due to size of the screen width
            if(window.innerWidth < 1024) {
                var charts=document.getElementsByClassName("chart");
                for (let i = 0; i < charts.length; i++)
                    charts[i].innerHTML =
                        "<p>Chart is too large. Cannot display in current view.</p>"
            }

            // json encode php array. i.e. convert php array to json array
            <?php
            $recordDate = json_encode(array_reverse($performanceData['recordDate']));
            $cpuUsage = json_encode(array_reverse($performanceData['cpuUsage']));
            $totalMemory = json_encode(array_reverse($performanceData['totalMemory']));
            $usedMemory = json_encode(array_reverse($performanceData['usedMemory']));
            $unusedMemory = json_encode(array_reverse($performanceData['unusedMemory']));
            $processCount = json_encode(array_reverse($performanceData['processCount']));
            $processRunning = json_encode(array_reverse($performanceData['processRunning']));
            $processSleeping = json_encode(array_reverse($performanceData['processSleeping']));
            echo "var record_date_arr = ". $recordDate . ";\n";
            echo "var cpu_usage_arr = ". $cpuUsage . ";\n";
            echo "var total_memory_arr = ". $totalMemory . ";\n";
            echo "var used_memory_arr = ". $usedMemory . ";\n";
            echo "var unused_memory_arr = ". $unusedMemory . ";\n";
            echo "var process_count_arr = ". $processCount . ";\n";
            echo "var process_running_arr = ". $processRunning . ";\n";
            echo "var process_sleeping_arr = ". $processSleeping . ";\n";
            ?>

            // ----------------- CPU Usage Chart -----------------
            var ctx = document.getElementById("cpu_line_chart").getContext('2d');
            var cpu_line_chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: record_date_arr,
                    datasets: [{
                        label: 'CPU Usage',
                        fill: false,
                        data: cpu_usage_arr,
                        borderColor: 'rgb(255, 99, 132)',
                        pointBackgroundColor: 'rgb(255, 99, 132)',
                        pointRadius: 0,
                        borderWidth: 2.3
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'CPU Usage'
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "CPU Usage (%)"
                            },
                            grid: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "Time"
                            }
                        }],
                    }
                }
            });



            // ----------------- Process Count Chart -----------------
            var ctx = document.getElementById("process_count_chart").getContext('2d');
            var process_count_chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: record_date_arr,
                    datasets: [{
                        label: 'Processes',
                        fill: false,
                        data: process_count_arr,
                        borderColor: 'rgb(255, 99, 132)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                    }, {
                        label: 'Processes Running',
                        fill: false,
                        data: process_running_arr,
                        borderColor: 'rgb(54, 162, 235)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                    }, {
                        label: 'Processes Sleeping',
                        fill: false,
                        data: process_sleeping_arr,
                        borderColor: 'rgb(75, 192, 192)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Process Count'
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "Process Count"
                            },
                            grid: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "Time"
                            }
                        }],
                    }
                }
            });


            // ----------------- Memory Usage Chart -----------------
            var ctx = document.getElementById("memory_chart").getContext('2d');
            var memory_chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: record_date_arr,
                    datasets: [{
                        label: 'Total Memory',
                        fill: false,
                        data: total_memory_arr,
                        borderColor: 'rgb(255, 99, 132)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                    }, {
                        label: 'Unused Memory',
                        data: unused_memory_arr,
                        borderColor: 'rgb(75, 192, 192)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                        backgroundColor: 'rgb(75, 192, 192, 0.2)',
                    }, {
                        label: 'Used Memory',
                        data: used_memory_arr,
                        borderColor: 'rgb(54, 162, 235)',
                        pointRadius: 0,
                        borderWidth: 2.3,
                        backgroundColor: 'rgb(54, 162, 235, 0.2)',
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Memory Usage'
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "Memory Usage (MB)"
                            },
                            grid: {
                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: "Time"
                            }
                        }],
                    }
                }
            });
        </script>
    <?php }?>
</div>