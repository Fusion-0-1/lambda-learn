<?php use \app\model\User\Lecturer; ?>
<link rel="stylesheet" href="/css/course/course_overview.css">

<div class="border main-container v-center flex-gap responsive-container">
    <h3>Course Overview</h3>
    <div class="card">

        <?php foreach ($courses as $course) { ?>
            <?php if ($_SESSION['user-role'] != 'Coordinator') { ?>
                <a href="<?php echo "/course_page?course_code=" . $course->getCourseCode() ?>" class="link">
            <?php } else { ?>
                <a href="<?php echo "/marks_upload?course_code=" . $course->getCourseCode() ?>" class="link">
            <?php }?>
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
                            <?php
                            $lecRegNos = $course->getLecsRegNo();
                            $names = "";
                            for($i = 0; $i < min(2, sizeof($lecRegNos)); $i++) {
                                $names .= Lecturer::getLecturerName($lecRegNos[$i]) . ", ";
                            }
                            echo substr($names, 0, -2);
                            ?>
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
