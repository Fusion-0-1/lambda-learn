<link rel="stylesheet" href="/css/course/course_overview.css">

<div class="border main-container v-center flex-gap responsive-container">
    <h3>Course Overview</h3>
    <div class="card">

        <?php foreach ($courses as $course) { ?>
            <a <?php if ($_SESSION['user-role'] != 'Coordinator') { echo 'href="/course_page?course_code='.$course->getCourseCode().'"';} ?> class="link">
                <div class="cards">
                    <div class="cards-inside">
                        <div class="course-name"><?php echo $course->getCourseName()?></div>
                    </div>
                    <div class="border-style"></div>
                    <div class="grid-content">
                        <div class="course-code"><?php echo $course->getCourseCode()?></div>
                        <div class="lecturer-name"><?php echo $course->getLecFirstName()." ".$course->getLecLastName()?></div>
                        <div class="percentage"><div class="percentage-inside">80%</div></div>
                    </div>
                </div>
            </a>
        <?php } ?>

    </div>
</div>
