<link rel="stylesheet" href="css/calender.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<script src="js/calender.js" defer></script>

<div class="main-container border v-center flex-gap responsive-container">
    <div class="main border">
        <h3>Calender</h3>
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
                <table>
                    <tr>
                        <th class="task-heading"> Tuesday </th>
                        <th class="task-date"> January 4 2023 </th>
                    </tr>
                    <tr>
                        <td class="task-content"> CS 2003 Assignment 1 </td>
                        <td class="task-time"> 08:30 </td>
                    </tr>
                    <tr>
                        <td class="task-content"> CS 2001 Labsheet 4 </td>
                        <td class="task-time"> 09:30 </td>
                    </tr>
                    <tr>
                        <td class="task-content"> CS 2002 Tutorial </td>
                        <td class="task-time"> 10:30 </td>
                    </tr>
                    <tr>
                        <td class="task-content"> CS 2004 Online Quiz </td>
                        <td class="task-time"> 11:30 </td>
                    </tr>
            </div>
        </div>
    </div>
</div>

