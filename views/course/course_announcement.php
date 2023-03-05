<link rel="stylesheet" href="css/announcement.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h2 class="text-center course_name"><?php echo $course_code?></h2>
    <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
        <form method="post" action="course_announcement" class="announcement_card border">
            <input type="text" value="<?php echo $course_code?>" name="course_code" hidden>
            <div class="topic_container_add grid v-center h-justify">
                <textarea id="heading_textarea" name="heading" placeholder="Add Announcement Heading..."
                          class="add_headline text-bold v-center text-justify" id="" wrap="hard"></textarea>

                <button id="publishbtn" class="btn confirm-btn h-center v-center">Publish</button>
            </div>
            <div class="announcement_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <div class="add_name">
                        <?php
                            $profile = unserialize($_SESSION['user']);
                            echo $profile->getFirstName()." ".$profile->getLastName();
                        ?>
                    </div>
                </div>
                <div  class="add_announcement_content_div">
                    <textarea id="content_textarea" name="content" placeholder="Add Announcement content...   " class="add_announcement_content text-justify"></textarea>
                </div>
            </div>
        </form>
    <?php } ?>

    <?php foreach ($announcements as $ann) { ?>
        <div class="announcement_card border">
            <div class="topic_container grid v-center h-justify container_edit_delete">
                <h4 class="heading_content text-bold text-justify"><?php echo $ann->getHeading()?></h4>
                <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
                    <div class="edit_delete_timeremaining grid v-center">
                        <div class="edit_time" id="timeremaning"><b>30</b><span> mins left</span></div>
                        <a href="" class="deletebtn" id="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <a href="" class="editbtn" id="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
                    </div>
                <?php } ?>
            </div>
            <div class="announcement_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <div class="view_lecture_name_and_date_time">Mr. Nimal Kodikar</div>
                    <div class="view_lecture_name_and_date_time text-right">
                        <?php
                        $utcTime = $ann->getPublishDate();
                        $sriLankanTimezone = new DateTimeZone('Asia/Colombo');
                        $date = new DateTime($utcTime, new DateTimeZone('UTC'));
                        $date->setTimezone($sriLankanTimezone);
                        $sriLankanDateAndTime = $date->format('l, F d, Y | H:i');
                        echo $sriLankanDateAndTime;
                        ?>
                    </div>
                </div>
                <p class="text-justify">
                    <?php echo $ann->getContent()?>
                </p>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    textarea = document.querySelector("#heading_textarea");
    textarea.addEventListener('input', autoResize, false);

    textarea = document.querySelector("#content_textarea");
    textarea.addEventListener('input', autoResize, false);

    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }
</script>