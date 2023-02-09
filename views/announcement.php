<link rel="stylesheet" href="css/announcement.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h2 class="text-center course_name">Site Announcements</h2>
    <?php if ($_SESSION['user-role'] == 'Admin' or $_SESSION['user-role'] == 'Coordinator') {?>
        <div class="announcement_card border">
            <div class="topic_container_add grid v-center h-justify">
                <textarea id="heading_textarea" name="heading" placeholder="Add Announcement Heading..."
                          class="add_headline text-bold v-center text-justify" id="" wrap="hard"></textarea>

                <button class="btn confirm-btn h-center v-center">Publish</button>

            </div>
            <div class="announcement_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <input type="text" name="name" placeholder="Enter Your Name... " class="add_name">
                    <div class="view_lecture_name_and_date_time text-right">2018-02-21 12:00:00</div>
                </div>
                <div  class="add_announcement_content_div">
                    <textarea id="content_textarea" name="content" placeholder="Add Announcement content...   " class="add_announcement_content text-justify"></textarea>
                </div>
            </div>
        </div>
        <?php } ?>
<!-- edit and delete button-->

    <div class="announcement_card border">
        <div class="topic_container grid v-center h-justify container_edit_delete" >
            <h4 class="heading_content text-bold text-justify">Rescheduling the tutorial.</h4>
            <?php if ($_SESSION['user-role'] == 'Admin' or $_SESSION['user-role'] == 'Coordinator') {?>
                <div class="edit_delete_timeremaining grid v-center">
                    <div class="edit_time"><b>30</b><span> mins left</span></div>
                    <a href="" class="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                    <a href="" class="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
                </div>
            <?php } ?>
        </div>
        <div class="announcement_card_inside border">
            <div class="container_heading grid h-justify v-center">
                <div class="view_lecture_name_and_date_time">Mr. Nimal Kodikara</div>
                <div class="view_lecture_name_and_date_time text-right">2018-02-21 12:00:00</div>
            </div>
            <p class="text-justify">
                Dear Students,

                As per your requests, today's tutorial session is rescheduled to Monday, 13th of February 2023 from 10.00 AM to 12.00 PM at the Mini Auditorium. You will have the first in-class assignment on Tuesday, 14th of February 2023 as informed earlier.

                Thank you
            </p>
        </div>
    </div>

    <?php foreach ($announcements as $ann) { ?>
        <div class="announcement_card border">
            <div class="topic_container grid v-center h-justify container_edit_delete">
                <h4 class="heading_content text-bold text-justify"><?php echo $ann->getHeading()?></h4>
            </div>
            <div class="announcement_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <div class="view_lecture_name_and_date_time">Mr. Nimal Kodikar</div>
                    <div class="view_lecture_name_and_date_time text-right"><?php echo $ann->getPublishDate()?></div>
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