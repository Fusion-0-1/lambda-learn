<link rel="stylesheet" href="css/announcement.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h3>Site Announcements</h3>

    <?php if ($_SESSION['user-role'] == 'Admin' or $_SESSION['user-role'] == 'Coordinator') {?>
        <form method="post" action="/site_announcement" class="announcement-card border">
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
                <?php if ($_SESSION['user-role'] == 'Admin' or $_SESSION['user-role'] == 'Coordinator') {?>
                    <div class="edit-delete-timeremaining grid v-center">
                        <div class="edit-time" id="timeremaning"><b>30</b><span> mins left</span></div>
                        <a href="" class="deletebtn link" id="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <button class="editbtn link" id="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image" onclick="announcementupdate(' <?php echo $ann->getHeading()."','".$ann->getContent()."','".$ann->getAnnouncementId()."','".$ann->getPublishDate()."'";?>)"></button>
                    </div>
                <?php } ?>
            </div>
            <div class="announcement-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="view-lecture-name-and-datetime">Mr. Nimal Kodikar</div>
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

<div class="modal" id="card_edit_modal">
    <div class="card-edit-modal">
        <form method="post" action="/update_site_announcement" class="announcement-card border announcement-card-border">
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
                <button id="publishbtn" class="btn confirm-btn h-center v-center modal-publish-btn">Publish</button>
                <button id="cancelbtn" class="cancel-btn h-center v-center">Cancel</button>
            </div>
            <input id="announcement_id" type="text" name="announcement_id" hidden>
        </form>
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

    const editmodal = document.getElementById('card_edit_modal')
    function announcementupdate(edit_heading,edit_content,edit_btn_id){

        editmodal.style.display='block';
        document.getElementById('heading_textarea_edit').value = edit_heading;
        document.getElementById('content_textarea_edit').value = edit_content;
        document.getElementById('announcement_id').value = edit_btn_id;
    }
    modal_cancel(editmodal);
</script>