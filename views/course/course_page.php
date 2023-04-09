<link rel="stylesheet" href="css/course/course_page.css">
<link rel="stylesheet" href="css/submission_popup.css">

<div class="modal hide" id="modal_submission">
    <div class="popup-card modal-content">
        <span class="close">&times;</span>
        <div class="course-name flex h-center text-bold text-center">Data Structures and Algorithms III</div>
        <div class="course-code flex h-center">CS 2003</div>

        <div class="submission-topic text-bold">Submission 1 - String Matching</div>
        <div class="submissions-card-inside">
            <div class="due-date-div grid h-justify v-center">
                <div class="due-date-heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_due_date.png">
                    <div>Due-Date</div>
                </div>
                <div class="due-date-contain">Wednesday, September 2, 2022       |   12.00 PM</div>
            </div>
            <div class="time-remaning-div grid h-justify v-center">
                <div class="due-date-heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_time_remaining.png">
                    <div>Time remaining</div>
                </div>
                <div class="due-date-contain flex h-center">-- --</div>
            </div>

            <div class="break-line"></div>

            <div class="time-remaning-div grid h-justify v-center">
                <div class="due-date-heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_granding_status.png">
                    <div>Grading status</div>
                </div>
                <div class="due-date-contain flex h-center">Pending</div>
            </div>
            <div class="time-remaning-div grid h-justify v-center">
                <div class="due-date-heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_file_submission.png">
                    <div>File submission</div>
                </div>
                <div class="due-date-contain flex h-center">StringMatching_01.zip</div>
            </div>
            <div class="time-remaning-div grid h-justify v-center">
                <div class="due-date-heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_submitted-date.png">
                    <div>Submitted Date</div>
                </div>
                <div class="due-date-contain flex h-center submitted-date">Wednesday, September 2, 2022  |  10.01 PM</div>
            </div>
            <div class="submit-buttons grid h-center">
                <div class="edit-btn submission-btn text-center">Add submission</div>
                <div class="edit-btn submission-btn text-center">Edit submission</div>
            </div>
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
                    <div class="progress-bar student-progress border-radius"></div>
                </div>
                <div class="progress-value flex h-end v-center"><h5> 20% </h5></div>
            </div>
        <?php } ?>
            <h5> Topic Progress </h5>
            <div class="flex flex-row">
                <?php foreach ($course->getTopics() as $courseTopic) {
                    foreach ($courseTopic->getSubTopics() as $courseSubTopic) {
                        if($courseSubTopic->getIsBeingTracked()==1){?>
                            <div class="progress-bar-inner border-radius width-full" id="topic1">
                                <div class="progress-bar border-radius flex" id="topic1-value"></div>
                                <div class="topic-progress-label"> <?php echo "Topic " . $courseTopic->getTopicId()?> </div>
                            </div>
                        <?php
                            break;
                        }
                    }
                } ?>

<!--                <div class="progress-bar-inner border-radius" id="topic1">-->
<!--                    <div class="progress-bar border-radius" id="topic1-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 1 </div>-->
<!--                </div>-->
<!--                <div class="progress-bar-inner border-radius" id="topic2">-->
<!--                    <div class="progress-bar border-radius" id="topic2-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 2 </div>-->
<!--                </div>-->
<!--                <div class="progress-bar-inner border-radius" id="topic3">-->
<!--                    <div class="progress-bar border-radius" id="topic3-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 3 </div>-->
<!--                </div>-->
<!--                <div class="progress-bar-inner border-radius" id="topic4">-->
<!--                    <div class="progress-bar border-radius" id="topic4-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 4 </div>-->
<!--                </div>-->
<!--                <div class="progress-bar-inner border-radius" id="topic5">-->
<!--                    <div class="progress-bar border-radius" id="topic5-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 5 </div>-->
<!--                </div>-->
<!--                <div class="progress-bar-inner border-radius" id="topic6">-->
<!--                    <div class="progress-bar border-radius" id="topic6-value"></div>-->
<!--                    <div class="topic-progress-label"> Topic 6 </div>-->
<!--                </div>-->
                <!--TODO: calculate the progress percentage-->
                <div class="progress-value flex h-end v-center"><h5> 35% </h5></div>
            </div>
        </div>
    </div>

    <div class="outer-secondary-container flex flex-row h-justify">
        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Announcements </h5>
                <!-- TODO: Add course code here-->
                <a href="/course_announcement?course_code=<?php echo ('CS 2001')?> " class="hyperlink"> View all </a>
            </div>
            <button class="inner-container border-radius text-left"> DSA - Tutorial Session </button>
            <button class="inner-container border-radius text-left"> SCS2201_Rescheduling the lecture on 15/09/2022 </button>
            <button class="inner-container border-radius text-left"> Assignment 1 Details - String Matching </button>
        </div>

        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Submissions </h5>
                <!-- TODO: Add course code here-->
                <a href="/submissions?course_code=<?php echo ('CS 2001')?>" class="hyperlink"> View all </a>
            </div>
            <button class="inner-container border-radius text-left" id="submission1"> Submission 3 - Greedy Alogrothms </button>
            <button class="inner-container border-radius text-left"> Submission 2 - Greedy Alogorithms </button>
            <button class="inner-container border-radius text-left"> Submission 1 - String Matching </button>
        </div>

    </div>

    <div class="outer-secondary-container">
        <div class="secondary-container border border-radius flex flex-column">
            <h5> Course Topics </h5>
            <hr class="hr">
            <div class="topic-container flex flex-row item-gap flex-wrap">
                <?php foreach ($course->getTopics() as $courseTopic) {?>
                    <div class="course-topic border border-radius flex flex-column ">
                        <h5> <?php echo $courseTopic->getTopicId().". ".$courseTopic->getTopicName()?> </h5>
                            <?php foreach ($courseTopic->getSubTopics() as $courseSubTopic) {?>
                                <div>
                                    <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                                        <h5> <?php echo $courseSubTopic->getSubTopicId()." ".$courseSubTopic->getSubTopicName()?> </h5>
                                        <input type="checkbox" name="cs1208-1.2" id="cs1208-1.2" class="topic-check">
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
        var modal_submission = document.getElementById("modal_submission");
        var btn = document.getElementById("submission1");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal_submission.style.display = "block";
        }
        span.onclick = function() {
            modal_submission.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal_submission) {
                modal_submission.style.display = "none";
            }
        }
    </script>
</div>