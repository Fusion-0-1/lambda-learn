<link rel="stylesheet" href="css/announcement.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h3><?php echo $course_code?></h3>
    <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
        <form method="post" action="course_announcement" class="announcement-card border">
            <input type="text" value="<?php echo $course_code?>" name="course_code" hidden>
            <div class="topic-container-add grid v-center h-justify">
                <textarea id="heading_textarea" name="heading" placeholder="Add Announcement Heading..."
                          class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>

                <button id="publishbtn" class="btn confirm-btn h-center v-center">Publish</button>
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
        <div class="announcement-card border">
            <div class="topic-container grid v-center h-justify">
                <h4 class="heading-content text-bold text-justify"><?php echo $ann->getHeading()?></h4>
                <?php if ($_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
                    <div class="edit-delete-timeremaining grid v-center">
                        <div class="edit-time" id="timeremaning"><b>30</b><span> mins left</span></div>
                        <a href="" class="deletebtn link" id="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <a href="" class="editbtn link" id="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
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