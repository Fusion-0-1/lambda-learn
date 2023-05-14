<?php use \app\model\User\Lecturer; ?>
<link rel="stylesheet" href="css/course/course_page.css">

<?php if (isset($mssg)) {
    if($mssg == 'Failed') { ?>
    <div id="mssg-modal" class="error-mssg text-justify">
        <p>The subtopic is not yet covered by the lecturer</p>
    </div>
<?php } } elseif (isset($is_topic_edited) or isset($is_sub_topic_edited)) {
    if($is_topic_edited == true and $is_sub_topic_edited == true) { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>Course topics and subtopics updated successfully.</p>
        </div>
    <?php } elseif($is_topic_edited == true) { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>Course topics updated successfully.</p>
        </div>
    <?php } elseif ($is_sub_topic_edited == true) { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>Course subtopics updated successfully</p>
        </div>
    <?php } else { ?>
        <div id="mssg-modal" class="error-mssg text-justify">
            <p>Failed to update topics or subtopics</p>
        </div>
    <?php }
} elseif (isset($add_topics)) {
    if($add_topics) { ?>
        <div id="mssg-modal" class="success-mssg text-justify">
            <p>New course topics and sub topics added successfully</p>
        </div>
<?php } else { ?>
        <div id="mssg-modal" class="error-mssg text-justify">
            <p>Failed to add topics and subtopics</p>
        </div>
    <?php }
}?>

<div class="modal hide" id="announcement-modal">
    <div class="announcement-view border border-radius">
        <input type="hidden" id="c-ann-id">
        <div class="header-container grid v-center h-justify">
            <div class="header-content text-bold text-justify" id="c-ann-heading"> </div>
        </div>
        <div class="announcement-view-inside border">
            <div class="lec-datetime grid h-justify v-center">
                <div id="c-ann-lec"> </div>
                <div class="text-right" id="c-ann-date"></div>
            </div>
            <p class="text-justify" id="c-ann-content"></p>
        </div>
    </div>
</div>

<div class="border main-container v-center flex flex-column flex-gap responsive-container">
    <h3 class="text-bold"><?php echo $course->getCourseName()?></h3>
    <h3><?php echo $course->getCourseCode()?></h3>

    <div class="outer-secondary-container">
        <div class="secondary-container border border-radius flex flex-column">
        <?php if ($_SESSION['user-role'] == 'Student') {?>
            <h5> Student Progress </h5>
            <div class="flex flex-row">
                <div class="progress-bar-outer border-radius">
                    <div class="progress-bar border-radius"
                         style="width: <?php echo $course->getStuTotalTopicCompletionProgress() . "%"?>"></div>
                </div>
                <div class="progress-value flex h-end v-center">
                    <h5> <?php echo $course->getStuTotalTopicCompletionProgress() . "%"?> </h5>
                </div>
            </div>
        <?php } ?>
            <h5> Topic Progress </h5>
            <div class="flex flex-row">
                <?php foreach ($course->getTopics() as $courseTopic) {
                    $count = 0;
                    foreach ($courseTopic->getSubTopics() as $courseSubTopics){
                        $count++;
                        if($courseSubTopics->getIsBeingTracked() == 1 and $count == 1){ ?>
                    <div class="progress-bar-inner border-radius width-full" id="topic1">
                        <div class="progress-bar border-radius flex" style="width:
                            <?php echo $courseTopic->getLecSubTopicCompletePercentage(). "%"?>">
                        </div>
                        <div class="topic-progress-label"> <?php echo "Topic " . $courseTopic->getTopicId()?> </div>
                    </div>
                    <?php
                    }
                    }
                }?>

                <div class="progress-value flex h-end v-center">
                    <h5><?php echo $course->getLecTotalTopicCompletionProgress() . "%"?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="outer-secondary-container flex flex-row h-justify">
        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Announcements </h5>
                <a href="/course_announcement?course_code=<?php echo $course->getCourseCode()?> " class="hyperlink"> View all </a>
            </div>
            <?php $count = 1;
                foreach ($courseAnnouncements as $c_ann) {
                    $count++; ?>
                    <button class="inner-container border-radius text-left" id="latest-course-announcement"
                            onclick="announcementview(<?php echo $c_ann->getAnnouncementId().", '".$c_ann->getHeading()."','"
                                .Lecturer::getLecturerName($c_ann->getLecRegNo())."','".$c_ann->getPublishDate()."','"
                                .$c_ann->getContent()."'";?>)">
                        <?php echo $c_ann->getHeading()?> </button>
                    <?php if ($count>3)
                        break;
                }?>
        </div>

        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Submissions </h5>
                <!-- TODO: Add course code here-->
                <a href="/submissions?course_code=<?php echo $course->getCourseCode()?>" class="hyperlink"> View all </a>
            </div>
            <button class="inner-container border-radius text-left" id="submission1"> Submission 3 - Greedy Alogrothms </button>
            <button class="inner-container border-radius text-left"> Submission 2 - Greedy Alogorithms </button>
            <button class="inner-container border-radius text-left"> Submission 1 - String Matching </button>
        </div>

    </div>

    <div class="outer-secondary-container">
        <div class="secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify">
                <h5 class="flex"> Course Topics </h5>
                <?php if($_SESSION['user-role'] == 'Lecturer') { ?>
                        <a href="/course_edit?course_code=<?php echo $course->getCourseCode()?>">
                            <button id="edit" type="button" class="edit-btn edit-btn-icon">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </a>
                <?php } ?>
            </div>
            <hr class="hr">
            <div class="topic-container flex flex-row item-gap flex-wrap">
                <?php foreach ($course->getTopics() as $courseTopic) {?>
                    <div class="course-topic border border-radius flex flex-column ">
                        <h5> <?php echo $courseTopic->getTopicId().". ".$courseTopic->getTopicName()?> </h5>
                            <?php foreach ($courseTopic->getSubTopics() as $courseSubTopic) {?>
                                <div>
                                    <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                                        <h5>
                                            <?php echo $courseSubTopic->getSubTopicId()." ".$courseSubTopic->getSubTopicName()?>
                                        </h5>
                                        <form  method="post" action="/course_page?course_code=<?php echo $course->getCourseCode(); ?>"
                                               name="update_progress_bar">
                                            <input type="hidden" name="update_progress_bar">
                                            <input type="hidden" value="<?php echo $course->getCourseCode()?>"
                                                   name="course_code">
                                            <input type="hidden" value="<?php echo $courseSubTopic->getSubTopicId()?>"
                                                   name="course_subtopic">
                                            <input type="hidden" value="<?php echo $courseTopic->getTopicId()?>"
                                                   name="course_topic">
                                            <?php if ($_SESSION['user-role'] == 'Student') {
                                                if($courseSubTopic->getStuIsCompleted()){?>
                                                    <button class="btn-checkbox-checked" type="submit">
                                                        <i class="fa-sharp fa-solid fa-check"></i>
                                                    </button>
                                            <?php } else { ?>
                                                    <button class="btn-checkbox" type="submit"></button>
                                            <?php }
                                            } ?>
                                            <?php if ($_SESSION['user-role'] == 'Lecturer') {
                                                if($courseSubTopic->getIsCovered()){?>
                                                    <button class="btn-checkbox-checked" type="submit">
                                                        <i class="fa-sharp fa-solid fa-check"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn-checkbox" type="submit"></button>
                                                <?php }
                                            } ?>
                                        </form>
                                    </div>
                                    <div class="course-sub-topic-content border-radius">
                                        <!--TODO: Retrieve recordings and lecture notes from the database-->
                                        <p><span class="icons fas fa-atom"></span> Sample Recording 1 </p>
                                        <p><span class="icons fas fa-atom"></span> Sample Recording 2 </p>
                                        <p><span class="icons fas fa-atom"></span> Sample Lecture Note </p>
                                    </div>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        const announcementmodal = document.getElementById('announcement-modal');
        function announcementview(c_ann_id, c_ann_heading, c_ann_lec, c_ann_date, c_ann_content) {
            announcementmodal.style.display = 'block';
            document.getElementById('c-ann-id').value = c_ann_id;
            document.getElementById('c-ann-heading').innerText = c_ann_heading;
            document.getElementById('c-ann-lec').innerText = c_ann_lec;
            document.getElementById('c-ann-date').innerText = c_ann_date;
            document.getElementById('c-ann-content').innerText = c_ann_content;
        }

        window.addEventListener("click", function(event) {
            if (event.target === announcementmodal) {
                announcementmodal.style.display = 'none';
            }
        });
    </script>
</div>