<link rel="stylesheet" href="css/course/course_initialization.css">
<script src="js/course/course_initialization.js" defer></script>

<div class="border main-container v-center flex-gap">

    <h3><?php echo $course->getCourseName()?></h3>
    <h4 class="text-center text-normal"><?php echo $course->getCourseCode()?></h4>

    <form method="post" action="<?php { echo '/course_page?course_code='.$course->getCourseCode();} ?>" enctype="multipart/form-data">
        <div class="border main-container v-center flex-gap">
            <h4>Course Topics</h4><hr><br>
            <div class="flex flex-wrap h-justify">
                <div id="topic" class="flex flex-wrap h-evenly flex-gap">
                    <input id="input_topic_1" class="input input-topic flex flex-gap" placeholder="Add new topic"
                           onkeyup="addTopic(this)" name="topics[]">
                </div>
            </div>
            <div class="flex margin-top h-center">
                <button type="button" id="save" class="edit-btn edit-btn-text" onclick="createSubtopics()">Save</button>
            </div>
        </div>

        <div class="border main-container flex-gap">
            <h4>Course Sub Topics</h4><hr><br>
            <p class="csv-header-format flex v-center h-center">
                The topics should be ticked in order to add the relevant topic for progress tracking. If the topic is not being ticked, It will not be considered for progress tracking.
            </p>
            <div id="course-topic" class="flex flex-gap flex-wrap h-center">
<!--                <div id="sub_topic_list_1" class="border container-course-topic v-center flex flex-gap v-center-->
<!--                 flex-column hide">-->
<!--                    <div class="flex flex-row v-center">-->
<!--                        <h5 id="topic-1" class="text-center remove-space">Topic...</h5>-->
<!--                        <input type="checkbox" id="check_box-1">-->
<!--                    </div>-->
<!--                    <div id="subtopic-1" class="border container-course-sub-topic v-center padding-none flex-->
<!--                    flex-column">-->
<!--                        <input class="input input-subtopic flex" placeholder="Add new sub topic..."-->
<!--                               onkeyup="removeIfEmpty(this)" name="subtopics!!subtopic-0">-->
<!--                        <input class="input input-subtopic flex" placeholder="Add new sub topic..."-->
<!--                               onkeyup="removeIfEmpty(this)" name="subtopics[0][]">-->
<!--                    </div>-->
<!--                    <button id="1" type="button" class="btn-circle" onclick="addSubTopic(this.id)" disabled>-->
<!--                        <i class="fa-solid fa-plus"></i>-->
<!--                    </button>-->
<!--                </div>-->
            </div>
            <div class="flex margin-top h-center">
                <button type="button" id="initialize" class="confirm-btn" disabled>Initialize course page</button>

                <div id="modal" class="modal" hidden>
                    <div class="warn-modal-content flex flex-column v-center">
                        <div class="text-center">
                            <img src="images/primary_icons/warning.svg" alt="warning">
                            <h4>Are You Sure?</h4>
                            <p>Once you initialize the course page, you cannot add new topics for progress tracking</p>
                        </div>
                        <div class="flex v-center text-right">
                            <button type="button" id="cancel-btn" class="text-bold cancel-btn">Cancel</button>
                            <button id="initialize-btn" class="text-bold warn-continue-btn">Initialize</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>