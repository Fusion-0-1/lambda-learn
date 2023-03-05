<link rel="stylesheet" href="css/submissions.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h2 class="text-center course_name"><?php echo $course_code?></h2>
        <div class="submissions_card border">
            <div class="topic_container_add grid v-center h-justify">
                    <textarea id="heading_textarea" name="heading" placeholder="Type your submission topic..."
                              class="add_headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                <button class="btn confirm-btn h-center v-center">Upload</button>
            </div>

            <div class="submissions_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <div class="view_points_and_marks">Marks Allocated:- <input type="text" name="name" placeholder="Add Marks ..." class="add_points_and_marks"></div>
                    <div class="view_points_and_marks">Points Allocated:- <input type="text" name="name" placeholder="Add Points..." class="add_points_and_marks"></div>
                    <div class="view_points_and_marks text-right">Thursday 27 October 2022 11:24 AM</div>
                </div>
                <div  class="add_submissions_content_div">
                    <textarea id="content_textarea" name="content" placeholder="Type your announcement here ..." class="add_submissions_content text-justify"></textarea>
                </div>
            </div>
        </div>

    <?php foreach ($submissions as $sub) { ?>
        <div class="submissions_card border">
            <div class="topic_container grid v-center h-justify container_edit_delete" >
                <h4 class="heading_content text-bold text-justify"><?php echo $sub->getTopic()?></h4>
                    <div class="edit_delete_timeremaining grid v-center">
                        <a href="" class="deletebtn"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <a href="" class="editbtn"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
                    </div>
            </div>

            <div class="submissions_card_inside border">
                <div class="container_heading grid h-justify v-center">
                    <div class="view_points_and_marks">Marks Allocated:- <?php echo $sub->getAllocatedMark()?></div>
                    <div class="view_points_and_marks">Points Allocated:- <?php echo $sub->getAllocatedPoint()?></div>
                    <div class="view_points_and_marks text-right"><?php echo $sub->getDueDate()?></div>
                </div>
                <p class="text-justify view_points_and_marks">
                    <?php echo $sub->getDescription()?>
                </p>
                <div class="submissions flex v-center">
                    <label class="sub_container">Visibility :
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                    <button class="marks_btn dark-btn" onclick="location.href='marks_upload'">Upload Marks</button>
                    <button class="marks_btn dark-btn">Download All Submissions</button>
                </div>
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
