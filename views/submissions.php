<link rel="stylesheet" href="css/submissions.css">

<div id="file-upload-container" class="main-container border v-center flex-gap responsive-container">
    <h3><?php echo $course_code?></h3>

    <form id="add-attachment" class="flex flex-column" action="/submissions" method="post" enctype="multipart/form-data">
        <div class="submissions-card border">
            <div class="topic-container-add grid v-center h-justify">
                    <textarea id="heading_textarea" name="heading" placeholder="Type your submission topic..."
                              class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                <button class="btn confirm-btn h-center v-center">Upload</button>
            </div>

            <div class="submissions-card-inside border">
                <div class="container-heading-input grid h-justify v-center">
                    <div class="view-points-and-marks">Marks Allocated:- <input type="text" name="mark" placeholder="Add Marks ..." class="add-points-and-marks"></div>
                    <div class="view-points-and-marks">Points Allocated:- <input type="text" name="point" placeholder="Add Points..." class="add-points-and-marks"></div>
                    <label for="duetime">Due date:- </label>
                    <input type="datetime-local" id="duetime" name="duetime" class="due-date">
                </div>
                <div  class="add-submissions-content-div">
                    <textarea id="content_textarea" name="content" placeholder="Type your announcement here ..." class="add-submissions-content text-justify"></textarea>
                </div>
            </div>

            <div class="flex v-center">

                <label for="visibility1" class="visibility-css"> Visibility </label><br>
                <input type="checkbox" id="visibility1" name="visibility">

            <input id="upload_attachment" type="file" name="attachment[]" accept=".pdf,.png,.jpg" multiple onchange="previewAttachment()" hidden >
            <label for="upload_attachment" class="attach-btn dark-btn flex-end h-center">Add Attachments</label>
            <div id="num-of-files">No Files Chosen</div>
            <div id="display-files" class="flex"></div>
            </div>

            <input id="course_code" type="text" name="course_code" value="<?php echo $course_code?>"hidden >
        </div>
    </form>

    <?php foreach ($submissions as $sub) { ?>
        <div class="submissions-card border">
            <div class="topic-container grid v-center h-justify" >
                <h4 class="heading-content text-bold text-justify"><?php echo $sub->getTopic()?></h4>
                    <div class="edit-delete-timeremaining grid v-center">
                        <a href="" class="deletebtn link"><img src="./images/announcement/Delete.png" alt="Delete image"></a>
                        <a href="" class="editbtn link"><img src="./images/announcement/Edit.png" alt="Edit image"></a>
                    </div>
            </div>

            <div class="submissions-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="view-points-and-marks">Marks Allocated:- <?php echo $sub->getAllocatedMark()?></div>
                    <div class="view-points-and-marks">Points Allocated:- <?php echo $sub->getAllocatedPoint()?></div>
                    <div class="view-points-and-marks text-right"><?php echo $sub->getDueDate()?></div>
                </div>
                <p class="text-justify view-points-and-marks">
                    <?php echo $sub->getDescription()?>

                </p>
                <form class="submissions flex v-center" action="/submission_visibility" method="post">

                    <label for="visibility2"> Visibility </label><br>
                    <input type="hidden" name="visibility" value="0">
                    <input type="checkbox" onchange="this.form.submit()" id="visibility2" name="visibility" value="1" <?php echo $sub->getVisibility() ? 'checked' : ''; ?>>
                    <button class="marks-btn dark-btn" onclick="location.href='marks_upload'">Upload Marks</button>
                    <button class="marks-btn dark-btn">Download All Submissions</button>
                    <?php
                    $attachmentPath = $sub->getLocation();
                    $attachmentFiles = $sub->getAttachmentFiles($attachmentPath);
                    ?>
                        <?php foreach ($attachmentFiles as $file) { ?>
                            <div class="files-views"><a href="<?php echo $file ?>" class="text-no-decoration" target="_blank"><?php echo $file ?></a></div>
                        <?php } ?>
                    <input id="course_code" type="text" name="course_code" value="<?php echo $sub->getCourseCode() ?>"hidden >
                    <input id="submission_id" type="text" name="submission_id" value="<?php echo $sub->getSubmissionId() ?>"hidden >
                </form>
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


    let fileInput = document.getElementById("upload_attachment");
    let fileContainer = document.getElementById("display-files");
    let numOfFiles = document.getElementById("num-of-files");


    function previewAttachment() {
        fileContainer.innerHTML = "";
        numOfFiles.textContent = `${fileInput.files.length} Files Selected`;

        for(i of fileInput.files){
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload=()=>{
                let fileBlob = new Blob([reader.result], { type: 'application/pdf' });
                let fileUrl = URL.createObjectURL(fileBlob);
                figCap.addEventListener('click', () => window.open(fileUrl));
            }
            fileContainer.appendChild(figure);
            reader.readAsArrayBuffer(i);
        }
    }
</script>
