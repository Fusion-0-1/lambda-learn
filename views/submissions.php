<?php use app\model\Submission; ?>
<link rel="stylesheet" href="css/submissions.css">
<link rel="stylesheet" href="css/submission_popup.css">

<div id="file-upload-container" class="main-container border v-center flex-gap responsive-container">
    <h3><?php echo $course_code ?></h3>
    <?php if ($_SESSION['user-role'] == 'Lecturer') { ?>
        <form id="add-attachment" class="flex flex-column" action="/submissions" method="post"
              enctype="multipart/form-data">
            <div class="submissions-card border">
                <div class="topic-container-add grid v-center h-justify">
                    <textarea id="heading_textarea" name="heading" placeholder="Type your submission topic..."
                              class="add-headline text-bold v-center text-justify" id="" wrap="hard"></textarea>
                    <button class="btn confirm-btn h-center v-center">Upload</button>
                </div>

                <div class="submissions-card-inside border">
                    <div class="container-heading-input grid h-justify v-center">
                        <div class="view-points-and-marks">Marks Allocated:- <input type="text" name="mark"
                                                                                    placeholder="Add Marks ..."
                                                                                    class="add-points-and-marks"></div>
                        <div class="view-points-and-marks">Points Allocated:- <input type="text" name="point"
                                                                                     placeholder="Add Points..."
                                                                                     class="add-points-and-marks"></div>
                        <label for="duetime">Due date:- </label>
                        <input type="datetime-local" id="duetime" name="duetime" class="due-date">
                    </div>
                    <div class="add-submissions-content-div">
                        <textarea id="content_textarea" name="content" placeholder="Type your announcement here ..."
                                  class="add-submissions-content text-justify"></textarea>
                    </div>
                </div>

                <div class="flex v-center">
                    <label for="visibility1" class="visibility-css"> Visibility </label><br>
                    <input type="checkbox" id="visibility1" name="visibility">
                    <input id="upload_attachment" type="file" name="attachment[]" accept=".pdf,.png,.jpg" multiple
                           onchange="previewAttachment()" hidden>
                    <label for="upload_attachment" class="attach-btn dark-btn flex-end h-center">Add Attachments</label>
                    <div id="num-of-files">No Files Chosen</div>
                    <div id="display-files" class="flex"></div>
                </div>

                <input id="course_code" type="text" name="course_code" value="<?php echo $course_code ?>" hidden>
            </div>
        </form>
    <?php } ?>


    <?php foreach ($submissions as $sub) { ?>
        <?php if ($_SESSION['user-role'] == 'Lecturer' or ($_SESSION['user-role'] == 'Student' and ($sub->getVisibility() !== null && $sub->getVisibility() == 1))) { ?>
            <div class="submissions-card border">
                <div class="topic-container grid v-center h-justify">
                    <?php if ($_SESSION['user-role'] == 'Lecturer') { ?>
                        <h4 class="heading-content text-bold text-justify"
                            id="edit-remove-heading"><?php echo $sub->getTopic() ?></h4>
                        <div class="edit-delete-timeremaining grid v-center">
                            <a href="" class="deletebtn link"><img src="./images/announcement/Delete.png"
                                                                   alt="Delete image"></a>
                            <a href="" class="editbtn link"><img src="./images/announcement/Edit.png"
                                                                 alt="Edit image"></a>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['user-role'] == 'Student') {
                        $profile = unserialize($_SESSION['user']);
                        if (Submission::stuSubExists($profile->getRegNo(), $sub->getCourseCode(), $sub->getSubmissionId())) { ?>
                            <!--                                Display already existing submission with submitted datetime, edit and delete buttons and NO update button -->
                            <?php foreach ($stu_submission as $stuSub) {
                                if ($sub->getSubmissionId() == $stuSub->getSubmissionId()) {
                                    ?>
                                    <div class="flex">
                                        <div>sumbitted date: <?php echo $stuSub->getSubmittedDate() ?>  </div>
                                        <div><?php
                                            $attachmentPath = $stuSub->getLocation();
                                            $attachmentFiles = $sub->getAttachmentFileNames($attachmentPath);
                                            foreach ($attachmentFiles as $file) { ?>
                                                <div class="files-views"><a
                                                            href="../../User Uploads/Submissions/<?php echo $sub->getCourseCode() . "/" . $sub->getSubmissionId() . "/Student_Submissions/" . $profile->getIndexNo() . '/' . $file ?>"
                                                            class="text-no-decoration" download="<?php echo $file ?>"
                                                            target="_blank"><?php echo $file ?></a></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            <?php } ?>
                            <div class="edit-delete-timeremaining grid v-center">
                                <button class="btn dark-btn h-center v-center " id="edit_stu_submission" onclick="updateStuAttachment('<?php echo $sub->getCourseCode() ."','".$sub->getSubmissionId()."','".$profile->getRegNo()."','".$sub->getDueDate()."','".$sub->getDescription()."'";?>)"> Edit
                                    Submission
                                </button>
                                <button class="btn dark-btn h-center v-center" id="submission_modal">Remove
                                    Submission
                                </button>
                            </div>
                        <?php } else { ?>
                            <h4 class="heading-content text-bold text-justify"
                                id="edit-remove-heading"><?php echo $sub->getTopic() ?></h4>
                            <div class="edit-delete-timeremaining grid v-center">
                                <button class="btn dark-btn h-center v-center" id="submission_modal"
                                        onclick="uploadsubmission('<?php echo $sub->getDueDate() . "','" . $sub->getSubmissionId() . "'"; ?>)">
                                    Upload
                                </button>
                            </div>
                        <?php }
                    } ?>
                </div>
                <div class="submissions-card-inside border">
                    <div class="container-heading grid h-justify v-center">
                        <div class="view-points-and-marks">Marks
                            Allocated:- <?php echo $sub->getAllocatedMark() ?></div>
                        <div class="view-points-and-marks">Points
                            Allocated:- <?php echo $sub->getAllocatedPoint() ?></div>
                        <div class="view-points-and-marks text-right"><?php echo $sub->getDueDate() ?></div>
                    </div>
                    <p class="text-justify view-points-and-marks"><?php echo $sub->getDescription() ?></p>
                    <form class="submissions flex v-center" action="/submission_visibility" method="post">
                        <?php if ($_SESSION['user-role'] == 'Lecturer') { ?>
                            <label for="visibility2"> Visibility </label><br>
                            <input type="hidden" name="visibility" value="0">
                            <input type="checkbox" onchange="this.form.submit()" id="visibility2" name="visibility"
                                   value="1" <?php echo $sub->getVisibility() ? 'checked' : ''; ?>>
                            <button class="marks-btn dark-btn" onclick="location.href='marks_upload'">Upload Marks
                            </button>
                            <button class="marks-btn dark-btn">Download All Submissions</button>
                        <?php } ?>
                        <?php
                        $attachmentPath = $sub->getLocation();
                        $attachmentFiles = $sub->getAttachmentFileNames($attachmentPath);
                        foreach ($attachmentFiles as $file) { ?>
                            <div class="files-views"><a
                                        href="../../User Uploads/Submissions/<?php echo $sub->getCourseCode() . "/" . $sub->getSubmissionId() . "/Lecturer_Attachments/" . $file ?>"
                                        class="text-no-decoration" download="<?php echo $file ?>"
                                        target="_blank"><?php echo $file ?></a></div>
                        <?php } ?>
                        <input id="course_code" type="text" name="course_code"
                               value="<?php echo $sub->getCourseCode() ?>" hidden>
                        <input id="submission_id" type="text" name="submission_id"
                               value="<?php echo $sub->getSubmissionId() ?>" hidden>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<div class="modal" id="modal_submission" hidden>
    <div class="popup-card modal-content">
        <form method="post" action="stu_submissions" id="stu_submission" enctype="multipart/form-data">
            <span class="close">&times;</span>
            <div class="course-name flex h-center text-bold text-center">Data Structures and Algorithms III</div>
            <div class="course-code flex h-center"><?php echo $course_code ?></div>

            <div class="submission-topic text-bold">Submission 1 - String Matching</div>
            <div class="submissions-card-insides">
                <div class="due-date-div grid h-justify v-center">
                    <div class="due-date-heading flex v-center">
                        <img src="/images/submissions_popup/submission_pop_due_date.png">
                        <div>Due Date</div>
                    </div>
                    <div class="due-date-contain text-center" id="modal_due_date"></div>
                </div>
                <div class="time-remaning-div grid h-justify v-center">
                    <div class="due-date-heading flex v-center">
                        <img src="/images/submissions_popup/submission_pop_time_remaining.png">
                        <div>Time remaining</div>
                    </div>
                    <div class="due-date-contain text-center flex h-center" id="remaining_time"></div>
                </div>

                <div class="break-line"></div>

                <div class="time-remaning-div grid h-justify v-center">
                    <div class="due-date-heading flex v-center">
                        <img src="/images/submissions_popup/submission_pop_granding_status.png">
                        <div>Grading status</div>
                    </div>
                    <div class="due-date-contain flex h-center">Pending</div>
                </div>
                <div class="text-right file-size-text">*Max Files Size 50MB</div>
                <div class="time-remaning-div-filesize grid h-justify v-center">
                    <div class="due-date-heading flex v-center">
                        <img src="/images/submissions_popup/submission_pop_file_submission.png">
                        <div>File submission</div>
                    </div>
                    <div class="due-date-contain flex h-center" id="display-stu-files">- -</div>
                </div>
                <div class="time-remaning-div grid h-justify v-center">
                    <div class="due-date-heading flex v-center">
                        <img src="/images/submissions_popup/submission_pop_submitted-date.png">
                        <div>Submitted Date</div>
                    </div>
                    <div class="due-date-contain flex h-center submitted-date"> - -</div>
                </div>
                <div class="submit-buttons flex h-center">
                    <input id="upload_stu_attachment" type="file" name="attachment" accept=".pdf,.png,.jpg,.zip"
                           onchange="previewStuAttachment()" hidden>
                    <label for="upload_stu_attachment" class="edit-btn submission-btn text-center">Add
                        submission</label>

                    <button class="edit-btn submission-btn text-center hide" id="edit-stu-submission"
                            onclick="editAttachment()">Edit submission
                    </button>
                    <button class="edit-btn submission-btn text-center hide" id="remove-stu-submission"
                            onclick="removeAttachment()">Remove submission
                    </button>
                    <button class="edit-btn submission-btn text-center hide" id="save-btn">
                        Save
                    </button>
                    <button class="edit-btn submission-btn text-center hide" onclick="cancelStuAttachment()"
                            id="stu-cancel-btn">Cancel
                    </button>
                </div>
            </div>

            <input id="submission_stu_id" type="text" name="submission_stu_id" hidden>
            <input id="course_code" type="text" name="course_code" value="<?php echo $course_code ?>" hidden>
            <input id="stu_reg_no" type="text" name="stu_reg_no" value="<?php
            $profile = unserialize($_SESSION['user']);
            echo $profile->getRegNo();
            ?>" hidden>
        </form>
    </div>
</div>

<div class="modal" id="update_stu_submission" hidden>
    <div class="card-edit-modal">
        <form method="post" action="/update_stu_submission">
        <div class="submissions-card border">
            <div class="topic-container grid v-center h-justify">
                <h4 class="heading-content text-bold text-justify"
                    id="edit-remove-heading"></h4>
                <div class="edit-delete-timeremaining grid v-center">
                    <div id="update-display-stu-files"></div>
                    <input id="update_stu_attachment" type="file" name="attachment" accept=".pdf,.png,.jpg,.zip"
                           onchange="updatePreviewStuAttachment()" hidden>
                    <label for="update_stu_attachment" class="edit-btn submission-btn text-center">Add
                        submission</label>
                </div>
            </div>
            <div class="submissions-card-inside border">
                <div class="container-heading grid h-justify v-center">
                    <div class="view-points-and-marks text-right flex">
                        Due Date:- <p id="stu_update_due_date"></p>
                    </div>
                </div>
                <p class="text-justify view-points-and-marks" id="stu_update_description"></p>
            </div>
            <div class="modal-btns flex h-center">
                <button id="stu_update_cancel_btn" type="button" class="cancel-btn h-center v-center">Cancel</button>
                <button id="publishbtn" type="submit" class="btn confirm-btn h-center v-center modal-publish-btn">Publish</button>
            </div>
        </div>
            <input id="stu_update_course_code" type="text" name="stu_update_course_code" hidden>
            <input id="stu_update_submission_id" type="text" name="stu_update_submission_id" hidden>
            <input id="stu_update_reg_no" type="text" name="stu_update_reg_no" hidden>
        </form>
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


    let fileInput = document.getElementById("upload_attachment");
    let fileContainer = document.getElementById("display-files");
    let numOfFiles = document.getElementById("num-of-files");

    function previewAttachment() {
        fileContainer.innerHTML = "";
        numOfFiles.textContent = `${fileInput.files.length} Files Selected`;

        for (i of fileInput.files) {
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload = () => {
                let fileBlob = new Blob([reader.result], {type: 'application/pdf'});
                let fileUrl = URL.createObjectURL(fileBlob);
                figCap.addEventListener('click', () => window.open(fileUrl));
            }
            fileContainer.appendChild(figure);
            reader.readAsArrayBuffer(i);
        }
    }

    function previewStuAttachment() {
        const fileInput = document.getElementById("upload_stu_attachment");
        const fileContainer = document.getElementById("display-stu-files");
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        fileContainer.innerHTML = "";

        if (fileInput.files.length === 1) {
            const file = fileInput.files[0];
            if (file.size <= maxSize) {
                const reader = new FileReader();
                const figure = document.createElement("figure");
                const figCap = document.createElement("figcaption");
                figCap.innerText = file.name;
                figure.appendChild(figCap);
                reader.onload = () => {
                    const fileBlob = new Blob([reader.result], {type: "application/pdf,image/jpeg,image/png,image/jpg"});
                    const fileUrl = URL.createObjectURL(fileBlob);
                    figCap.addEventListener("click", () => window.open(fileUrl));
                };
                fileContainer.appendChild(figure);
                reader.readAsArrayBuffer(file);

                // show edit and remove submission buttons
                document.getElementById("save-btn").classList.remove("hide");
                document.getElementById("stu-cancel-btn").classList.remove("hide");
                // hide add submission button
                document.querySelector("label[for='upload_stu_attachment']").classList.add("hide");
            } else {
                alert("The selected file is too large. Please select a file that is 50MB or smaller.");
                fileInput.value = null;
            }
        }
    }

    function updatePreviewStuAttachment() {
        const fileInput = document.getElementById("update_stu_attachment");
        const fileContainer = document.getElementById("update-display-stu-files");
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        fileContainer.innerHTML = "";

        if (fileInput.files.length === 1) {
            const file = fileInput.files[0];
            if (file.size <= maxSize) {
                const reader = new FileReader();
                const figure = document.createElement("figure");
                const figCap = document.createElement("figcaption");
                figCap.innerText = file.name;
                figure.appendChild(figCap);
                reader.onload = () => {
                    const fileBlob = new Blob([reader.result], {type: "application/pdf,image/jpeg,image/png,image/jpg"});
                    const fileUrl = URL.createObjectURL(fileBlob);
                    figCap.addEventListener("click", () => window.open(fileUrl));
                };
                fileContainer.appendChild(figure);
                reader.readAsArrayBuffer(file);
            } else {
                alert("The selected file is too large. Please select a file that is 50MB or smaller.");
                fileInput.value = null;
            }
        }
    }

    function cancelStuAttachment() {
        const fileInput = document.getElementById("upload_stu_attachment");
        const fileContainer = document.getElementById("display-stu-files");

        // Hide the Save and Cancel buttons, show the Add button
        document.getElementById("save-btn").classList.add("hide");
        document.getElementById("stu-cancel-btn").classList.add("hide");
        document.querySelector("label[for='upload_stu_attachment']").classList.remove("hide");
        document.getElementById("edit-stu-submission").classList.add("hide");

        // Clear the file input and remove any displayed files
        fileInput.value = null;
        fileContainer.innerHTML = "";
    }

    function uploadsubmission(due_date, submission_id) {
        const modal_submission = document.getElementById('modal_submission')
        modal_submission.style.display = 'block';
        document.getElementById('submission_stu_id').value = submission_id;

        // Set the due date
        const dueDate = new Date(due_date);
        const dueDateString = dueDate.toDateString() + " " + dueDate.toLocaleTimeString();

        // Set the remaining time
        const remainingTimeElement = document.getElementById('remaining_time');
        let countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();

        function updateCountdown() {
            const currentTime = new Date();
            const timeDiff = dueDate.getTime() - currentTime.getTime();
            if (timeDiff <= 0) {
                remainingTimeElement.classList.add('overdue');
                remainingTimeElement.textContent = "Assignment is overdue by: " + Math.abs(Math.floor(timeDiff / (1000 * 60 * 60 * 24))) + " days " + Math.abs(Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))) + " hours";
                clearInterval(countdownInterval);
                countdownInterval = null;
            } else {
                remainingTimeElement.classList.remove('overdue');
                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
                const remainingTimeString = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
                remainingTimeElement.textContent = remainingTimeString;
            }
        }

        // Update the DOM
        document.getElementById('modal_due_date').textContent = dueDateString;

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function () {
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            modal_submission.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target == modal_submission) {
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                modal_submission.style.display = "none";
            }
        }
    }

    function removeHeading() {
        var heading = document.getElementById("edit-remove-heading");
        if (heading) {
            heading.remove();
        }
    }

    function updateStuAttachment(course_code,submission_id,reg_no,due_date,description) {
        const updateStuSubmission = document.getElementById('update_stu_submission');
        updateStuSubmission.style.display='block';
        console.log(course_code);
        document.getElementById('stu_update_course_code').value = course_code;
        document.getElementById('stu_update_submission_id').value = submission_id;
        document.getElementById('stu_update_reg_no').value = reg_no;
        document.getElementById('stu_update_due_date').innerText = due_date;
        document.getElementById('stu_update_description').innerText = description;
    }


</script>
