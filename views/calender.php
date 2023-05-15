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

            <?php if ($_SESSION['user-role'] == 'Student') {?>
                <div class="card">
                    <table>
                        <tr>
                            <th colspan="2" class="task-heading"> Upcoming Submissions </th>
                        </tr>
                        <?php $count = 1;
                        foreach ($submissions as $submission) {
                            $count++; ?>
                            <tr>
                                <td class="task-content"> <?php echo $submission->getCourseCode().' : '.$submission->getTopic()?> </td>
                                <td class="task-date"> <?php echo $submission->getDueDate() ?> </td>
                            </tr>
                            <?php if ($count>5)
                                break;
                        }?>
                    </table>
                </div>
            <?php } elseif ($_SESSION['user-role'] == 'Lecturer') {?>
                <div class="card">
                    <table>
                        <tr>
                            <th colspan="2" class="task-heading"> Upcoming Tasks </th>
                        </tr>
                        <?php $count = 1;
                        foreach ($tasks as $task) {
                            $count++; ?>
                            <tr class="task-container">
                                <td class="task-content"> <?php echo $task->getTitle() ?> </td>
                                <td class="task-date"> <?php echo $task->getDueDate() ?> </td>
                            </tr>
                            <?php if ($count>5)
                                break;
                        }?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

