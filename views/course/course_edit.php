<link rel="stylesheet" href="css/course/course_initialization.css">
<script src="js/course/course_initialization.js" defer></script>

<div class="border main-container v-center flex-gap">
    <h3><?php echo $course->getCourseName()?></h3>
    <h4 class="text-center text-normal"><?php echo $course->getCourseCode()?></h4>

    <form method="post" action="/edit_topics" enctype="multipart/form-data">
        <input type="hidden" name="course_code" value="<?php echo $course->getCourseCode()?>">
        <div class="border main-container v-center flex-gap">
            <h4>Edit course topics and sub topics</h4><hr><br>
            <div class="flex flex-gap flex-wrap h-center">
                <?php foreach ($course->getTopics() as $courseTopic) { ?>
                <div class="border container-course-topic v-center flex flex-gap v-center flex-column ">
                    <div class="flex flex-row v-center">
                        <input class="input input-topic flex flex-gap edit-course-input"
                               value="<?php echo $courseTopic->getTopicName()?>" name="update_topics[]" required>
                    </div>
                    <div class="border container-course-sub-topic v-center padding-none flex
                                    flex-column">
                        <?php foreach ($courseTopic->getSubTopics() as $courseSubTopic) { ?>
                        <input name="update_subtopics[<?php echo $courseTopic->getTopicId() ?>][]" class="input input-subtopic flex"
                               value="<?php echo $courseSubTopic->getSubTopicName()?>" required>
                        <?php } ?>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="flex margin-top h-center">
                <button type="submit" class="edit-btn edit-btn-text">Update</button>
            </div>
        </div>
    </form>

    <form method="post" action="/add_new_topics" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $course->getCourseCode()?>" name="course_code">
        <div class="border main-container v-center flex-gap">
            <h4>Add new topics and sub topics</h4><hr><br>
            <input type="hidden" value="<?php echo $course->getCourseCode()?>" name="course_code">
            <div class="flex flex-wrap h-justify">
                <div id="topic" class="flex flex-wrap h-evenly flex-gap">
                    <input id="input_topic_1" class="input input-topic flex flex-gap" placeholder="Add new topic"
                           onkeyup="addTopic(this)" name="topics[]">
                </div>
            </div>
            <div class="flex margin-top h-center">
                <button type="button" id="save" class="edit-btn edit-btn-text" onclick="createSubtopics()">Save</button>
            </div>
            <div id="course-topic" class="flex flex-gap flex-wrap h-center"></div>
            <div class="flex margin-top h-center">
                <button type="button" id="initialize" class="confirm-btn" disabled>Add new topics</button>
            </div>
        </div>
        <div class="flex margin-top h-center">
            <div id="modal" class="modal" hidden>
                <div class="warn-modal-content flex flex-column v-center">
                    <div class="text-center">
                        <img src="images/primary_icons/warning.svg" alt="warning">
                        <h4>Are You Sure?</h4>
                        <p>Once you have added new topics, they cannot be removed.</p>
                    </div>
                    <div class="flex v-center text-right">
                        <button type="button" id="cancel-btn" class="text-bold cancel-btn">Cancel</button>
                        <button id="initialize-btn" class="text-bold warn-continue-btn">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


