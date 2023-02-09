<link rel="stylesheet" href="/css/course/course_overview.css">

<div class="border main-container v-center flex-gap responsive-container">
    <h1 class="main_heading"><b>Course Overview</b></h1>
    <div class="card">

        <?php foreach ($courses as $course) { ?>
            <a <?php if ($_SESSION['user-role'] != 'Coordinator') { echo 'href="/cs1208"';} ?>>
                <div class="cards">
                    <div class="cards_inside">
                        <div class="course_name"><?php echo $course->getCourseName()?></div>
                    </div>
                    <div class="border_style"></div>
                    <div class="grid_content">
                        <div class="course_code"><?php echo $course->getCourseCode()?></div>
                        <div class="lecturer_name"><?php echo $course->getLecFirstName()." ".$course->getLecLastName()?></div>
                        <div class="precentage"><div class="precentage_inside">80%</div></div>
                    </div>
                </div>
            </a>
        <?php } ?>

    </div>
</div>
