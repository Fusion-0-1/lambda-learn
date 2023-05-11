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
                    <?php if ($_SESSION['user-role'] == 'Student') {
                        if($course->getTopics() == null){?>
                            <div class="border-style" style="width: 0"></div>
                        <?php } else { ?>
                            <div class="border-style" style="width: <?php echo $course->getStuTotalTopicCompletionProgress() . "%"?>"></div>
                        <?php } ?>
                    <?php } else {
                        if($course->getTopics() == null){?>
                            <div class="border-style" style="width: 0"></div>
                        <?php } else { ?>
                            <div class="border-style" style="width: <?php echo $course->getLecTotalTopicCompletionProgress() . "%"?>"></div>
                        <?php }
                    }?>
                    <div class="grid-content">
                        <div class="course-code"><?php echo $course->getCourseCode()?></div>
                        <div class="lecturer-name">
                            <?php foreach ($course->getLecsRegNo() as $lecRegNo) {
                                echo \app\model\User\Lecturer::getLecturerName($lecRegNo); ?>
                            <br>
                            <?php }?>
                        </div>

                        <?php if ($_SESSION['user-role'] == 'Student') {
                            if($course->getTopics() == null){?>
                                <div class="percentage"><div class="percentage-inside">0%</div></div>
                            <?php } else { ?>
                                <div class="percentage"><div class="percentage-inside"><?php echo $course->getStuTotalTopicCompletionProgress() . "%" ?></div></div>
                        <?php }
                        } else {
                            if($course->getTopics() == null){?>
                                <div class="percentage"><div class="percentage-inside">0%</div></div>
                            <?php } else { ?>
                                <div class="percentage"><div class="percentage-inside"><?php echo $course->getLecTotalTopicCompletionProgress() . "%" ?></div></div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </a>
        <?php } ?>

    </div>
</div>
