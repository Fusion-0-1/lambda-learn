<link rel="stylesheet" href="css/announcement.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h3><?php echo $course_code?></h3>
    <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
        <form method="post" action="course_announcement" class="announcement-card border">
            <input type="text" value="<?php echo $course_code?>" name="course_code" hidden>
            <div class="topic-container-add grid v-center h-justify">
                <textarea id="heading_textarea" name="heading" placeholder="Add Announcement Heading..."
                          class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                <button id="publishbtn" class="btn confirm-btn h-center v-center" onclick="return courseAnnouncementInsertValidate(document.getElementById('heading_textarea').value,document.getElementById('content_textarea').value)">Publish
                </button>
            </div>
            <div class="announcement-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="add-name">
                        <?php
                            $profile = unserialize($_SESSION['user']);
                            echo $profile->getFirstName()." ".$profile->getLastName();
                        ?>
                    </div>
                </div>
                <div  class="add-announcement-content-div">
                    <textarea id="content_textarea" name="content" placeholder="Add Announcement content...   " class="add-announcement-content text-justify"></textarea>
                </div>
            </div>
        </form>
    <?php } ?>

    <?php foreach ($announcements as $ann) { ?>
        <?php
        // Calculate the remaining time in minutes
        $publishTime = strtotime($ann->getPublishDate());
        $currentTime = time();
        $remainingTime = 3 - round(($currentTime - $publishTime) / 60);
        // If the remaining time is less than or equal to zero, hide the buttons
        if ($remainingTime <= 0) {
            $hideButtons = 'style="display:none;"';
        } else {
            $hideButtons = '';
        }
        ?>
        <?php
        $profile = unserialize($_SESSION['user']);
        $regno = $profile->getRegNo();
        $legregno = $ann->getLecRegNo();
        ?>
        <?php if($regno == $legregno && ($remainingTime > 0)){?>
            <div class="announcement-card border">
                <div class="topic-container grid v-center h-justify">
                    <h4 class="heading-content text-bold text-justify"><?php echo $ann->getHeading()?></h4>
                    <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
                        <div class="edit-delete-timeremaining grid v-center"<?php echo $hideButtons ?>>
                            <div class="edit-time" id="timeremaning"><b><?php echo $remainingTime ?></b><span> mins left</span></div>
                            <button class="deletebtn link" id="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image" onclick="announcementdelete('<?php echo $ann->getAnnouncementId()."'";?>)"></button>
                            <button class="editbtn link" id="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image" onclick="announcementupdate('<?php echo $ann->getHeading()."','".$ann->getContent()."','".$ann->getAnnouncementId()."','".$ann->getPublishDate()."'";?>)"></button>
                        </div>
                    <?php } ?>
                </div>
                <div class="announcement-card-inside border">
                    <div class="container-heading grid h-justify v-center">
                        <div class="view-lecture-name-and-datetime">Mr. Nimal Kodikara</div>
                        <div class="view-lecture-name-and-datetime text-right">
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
        <?php } else if ($remainingTime <= 0) { ?>
            <div class="announcement-card border">
                <div class="topic-container grid v-center h-justify">
                    <h4 class="heading-content text-bold text-justify"><?php echo $ann->getHeading()?></h4>
                </div>
                <div class="announcement-card-inside border">
                    <div class="container-heading grid h-justify v-center">
                        <div class="view-lecture-name-and-datetime">Mr. Nimal Kodikara</div>
                        <div class="view-lecture-name-and-datetime text-right">
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
    <?php } ?>
</div>

<div class="modal" id="card_edit_modal" hidden>
    <div class="card-edit-modal">
        <form method="post" action="/update_course_announcement" class="announcement-card border announcement-card-border">
            <input type="text" value="<?php echo $course_code?>" name="course_code" hidden>
                <div class="topic-container-add grid v-center h-justify">
                    <textarea id="heading_textarea_edit" name="heading" placeholder="Add Announcement Heading..."
                          class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                </div>
                <div class="announcement-card-inside border">
                    <div class="container-heading grid h-justify v-center">
                        <div class="add-name">
                            <?php
                            $profile = unserialize($_SESSION['user']);
                            echo $profile->getFirstName()." ".$profile->getLastName();
                            ?>
                        </div>
                    </div>
                <div  class="add-announcement-content-div">
                    <textarea id="content_textarea_edit" name="content" placeholder="Add Announcement content...   " class="add-announcement-content text-justify"></textarea>
                </div>
            </div>
            <div class="modal-btns flex h-center">
                <button type="submit" id="publishbtn" class="btn confirm-btn h-center v-center modal-publish-btn" onclick="return courseAnnouncementUpdateValidate(document.getElementById('heading_textarea_edit').value,document.getElementById('content_textarea_edit').value)">Publish
                </button>
                <button type="button" value="Cancel" id="edit-cancel-btn" class="cancel-btn h-center v-center cancel-btn-edit-modal">Cancel</button>
            </div>
            <input id="announcement_id" type="text" name="announcement_id" hidden>
            <input id="publish_date_time" type="text" name="publish_date_time" hidden>
        </form>
    </div>
</div>
<div id="delete-modal" class="modal" hidden>
    <form method="post" action="/delete_course_announcement">
        <div class="modal-content error-modal-content">
            <div class="flex flex-column v-center h-center">
                <img src="./images/primary_icons/error.svg">
                <h4 id="delete-warning" class="modal-header">Are you sure?</h4>
                <p class="modal-text">Once you delete announcement, you cannot undo the process</p>
                <section class="flex flex-row two-button-row">
                    <button type="submit" id="delete-btn" class="dark-btn error-btn">Delete</button>
                    <button type="button" id="delete-cancel-btn" class="dark-btn cancel-btn cancel-btn-edit">Cancel</button>
                </section>
            </div>
            <input id="announcement_id_delete" type="text" name="announcement_id_delete" hidden>
            <input type="text" value="<?php echo $course_code?>" name="course_code_delete" hidden>
        </div>
    </form>
</div>

<div id="warn-modal" class="modal" hidden>
    <div id="warn_msg_email" class="modal-content warn-modal-content" >
        <div class="flex flex-column v-center h-center">
            <img src="images/primary_icons/warning.svg">
            <h4 id="delete-warning">Input Field or Fields are Empty</h4>
            <div>
                <p>Please check whether heading or description fields are empty</p>
            </div>
            <section class="flex flex-row two-button-row">
                <button id="continue-btn" class="dark-btn cancel-btn warn-continue-btn">OK</button>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    textarea = document.querySelector("#heading_textarea");
    textarea.addEventListener('input', autoResize, false);

    textarea = document.querySelector("#content_textarea");
    textarea.addEventListener('input', autoResize, false);

    textarea = document.querySelector("#heading_textarea_edit");
    textarea.addEventListener('input', autoResize, false);

    textarea = document.querySelector("#content_textarea_edit");
    textarea.addEventListener('input', autoResize, false);

    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }

    const editmodal = document.getElementById('card_edit_modal');
    function announcementupdate(edit_heading,edit_content,edit_btn_id){

        editmodal.style.display='block';
        document.getElementById('heading_textarea_edit').value = edit_heading;
        document.getElementById('content_textarea_edit').value = edit_content;
        document.getElementById('announcement_id').value = edit_btn_id;
    }

    const cancelbtn = document.getElementById('edit-cancel-btn');
    cancelbtn.addEventListener('click', function () {
        editmodal.style.display = 'none';
    });
    document.addEventListener('click', function (event) {
        if (event.target === editmodal) {
            editmodal.style.display = 'none';
        }
    });

    function updateRemainingTime() {
        var elements = document.getElementsByClassName("edit-time");
        for (var i = 0; i < elements.length; i++) {
            var remainingTime = parseInt(elements[i].firstChild.textContent);
            if (remainingTime > 1) {
                remainingTime--;
                elements[i].firstChild.textContent = remainingTime;
                elements[i].lastChild.textContent = (remainingTime == 1) ? " min left" : " mins left";
            } else {
                elements[i].parentNode.style.display = "none";
            }
        }
    }
    setInterval(updateRemainingTime, 60000);

    const deleteCourseAnnouncementmodal = document.getElementById('delete-modal');
    function announcementdelete(announcement_id) {
        deleteCourseAnnouncementmodal.style.display='block';
        document.getElementById('announcement_id_delete').value = announcement_id;
    }

    const cancelBtn = document.getElementById('delete-cancel-btn');
    cancelBtn.addEventListener('click', function () {
        deleteCourseAnnouncementmodal.style.display = 'none';
    });
    document.addEventListener('click', function (event) {
        if (event.target === deleteCourseAnnouncementmodal) {
            deleteCourseAnnouncementmodal.style.display = 'none';
        }
    });

    //validation
    function courseAnnouncementInsertValidate(heading,content) {
        if (!heading || !content) {
            const modal = document.getElementById("warn-modal");
            modal.hidden = false;
            return false;
        }
        return true;
    }
    function courseAnnouncementUpdateValidate(heading,content) {
        if (!heading || !content) {
            const modal = document.getElementById("warn-modal");
            modal.hidden = false;
            return false;
        }
        return true;
    }
    document.getElementById("continue-btn").addEventListener("click", function() {
        document.getElementById("warn-modal").hidden = true;
    });

    const courseWarn = document.getElementById('warn-modal');
    document.addEventListener('click', function (event) {
        if (event.target === courseWarn) {
            courseWarn.style.display = 'none';
        }
    });
</script>