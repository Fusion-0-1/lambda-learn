<link rel="stylesheet" href="css/calender.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<script src="js/calender.js" defer></script>

<div class="main-container border v-center flex-gap responsive-container">
    <div class="main border">
        <h1 class="text-center">Calender</h1>
        <div class="flex h-justify">

            <div class="wrapper">
                <header class="flex v-center h-justify">
                    <p class="current-date"></p>
                    <div class="icons">
                        <span id="prev" class="material-symbols-rounded text-center">chevron_left</span>
                        <span id="next" class="material-symbols-rounded text-center">chevron_right</span>
                    </div>
                </header>
                <div class="calendar">
                    <ul class="weeks flex flex-wrap text-center">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                    </ul>
                    <ul class="days flex flex-wrap text-center text-bold">
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="cards_heading flex h-justify" >
                    <div class="week_days">Tuesday</div>
                    <div class="date">January 4 2023</div>
                </div>
                <div class="cards_heading cards_content flex h-justify v-center">
                    <div class="rank">Calender Task 1</div>
                    <div class="student_name">8:30</div>
                </div>

                <div class="cards_heading cards_content1 flex h-justify v-center">
                    <div class="rank">Calender Task 2</div>
                    <div class="student_name">09:30</div>
                </div>
                <div class="cards_heading cards_content flex h-justify v-center">
                    <div class="rank">Calender Task 3</div>
                    <div class="student_name">10:30</div>
                </div>

                <div class="cards_heading cards_content1 flex h-justify v-center">
                    <div class="rank">Calender Task 4</div>
                    <div class="student_name">11:30</div>
                </div>
            </div>
        </div>
    </div>

<!--  --------------time table-------------------  -->
    <div class="main border">
        <h1 class="h-center flex">Lecture Time Table</h1>
            <div class="table_main grid">
                <!-- Days container -->
                <div class="stages-container-row">
                    <div class="stages flex v-center h-center text-justify text-bold ">
                        <div class="stage">Monday</div>
                        <div class="stage">Tuesday</div>
                        <div class="stage">Wednesday</div>
                        <div class="stage">Thursday</div>
                        <div class="stage">Friday</div>
                    </div>
                </div>

                <!-- timing container -->
                <div class="timing-container-column">
                    <div class="timings flex flex-column h-justify text-bold text-center text-justify">
                        <div class="time">08:00 - 09:00</div>
                        <div class="time">09:00 - 10:00</div>
                        <div class="time">10:00 - 11:00</div>
                        <div class="time">11:00 - 12:00</div>
                        <div class="time">12:00 - 13:00</div>
                        <div class="time">13:00 - 14:00</div>
                        <div class="time">14:00 - 15:00</div>
                        <div class="time">15:00 - 16:00</div>
                        <div class="time">16:00 - 17:00</div>
                    </div>
                </div>

            </div>

    </div>

</div>

