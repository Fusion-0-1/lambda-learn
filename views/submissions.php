<link rel="stylesheet" href="css/submissions.css">

<div class="main-container border v-center flex-gap responsive-container">
    <h3>Data Structures and Algorithms - Submissions</h3>
        <div class="submissions-card border">
            <div class="topic-container-add grid v-center h-justify">
                    <textarea id="heading_textarea" name="heading" placeholder="Type your submission topic..."
                              class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                <button class="btn confirm-btn h-center v-center">Upload</button>
            </div>

            <div class="submissions-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="view-points-and-marks">Marks Allocated:- <input type="text" name="name" placeholder="Add Marks ..." class="add-points-and-marks"></div>
                    <div class="view-points-and-marks">Points Allocated:- <input type="text" name="name" placeholder="Add Points..." class="add-points-and-marks"></div>
                    <div class="view-points-and-marks text-right">Thursday 27 October 2022 11:24 AM</div>
                </div>
                <div  class="add-submissions-content-div">
                    <textarea id="content_textarea" name="content" placeholder="Type your announcement here ..." class="add-submissions-content text-justify"></textarea>
                </div>
            </div>
        </div>

        <div class="submissions-card border">
            <div class="topic-container grid v-center h-justify container_edit_delete" >
                <h4 class="heading-content text-bold text-justify">Assignment 01 - String Matching</h4>
                    <div class="edit-delete-timeremaining grid v-center">
                        <a href="" class="deletebtn link"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <a href="" class="editbtn link"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
                    </div>
            </div>

            <div class="submissions-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="view-points-and-marks">Marks Allocated:- 10</div>
                    <div class="view-points-and-marks">Points Allocated:- 50</div>
                    <div class="view-points-and-marks text-right">Thursday 27 October 2022 11:24 AM</div>
                </div>
                <p class="text-justify view-points-and-marks">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sapiente officia qui accusamus repellendus,
                    dolorem eveniet? Vitae, cum, harum architecto rerum similique velit facilis dolore ad libero quaerat
                    quibusdam incidunt, aliquam praesentium odit nobis sit consectetur totam dolores exercitationem
                    molestias accusamus quisquam. Est, nostrum quos! Ea aut dolores nam quasi assumenda.
                </p>
                <div class="submissions flex v-center">
                    <label class="sub-container">Visibility :
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                    <button class="marks-btn dark-btn" onclick="location.href='marks_upload'">Upload Marks</button>
                    <button class="marks-btn dark-btn">Download All Submissions</button>
                </div>
            </div>
        </div>
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
