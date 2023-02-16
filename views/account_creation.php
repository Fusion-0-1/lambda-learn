<link rel="stylesheet" href="css/account_creation.css">
<!--<link rel="stylesheet" href="css/profile.css">-->


<!-- TODO 1: Create invalid user modal and error prompt
    TODO 2: Update user continue click implementation
-->

<div id="warn-modal" class="modal" <?php if(!isset($updatedUsers)) echo "hidden";?>>
    <div class="modal-content warn-modal-content">
        <div class="flex flex-column v-center h-center">
            <img src="./images/primary_icons/warning.svg">
            <h4 id="delete-warning">Do you want to update existing students?</h4>
            <p>Following student are already registered. Would you like to continue?</p>
            <p id="stu-id-list" class="text-center">
                <?php
                $print = '';
                foreach ($updatedUsers as $student) {
                    $print .= $student->getRegNo() . ", ";
                }
                echo substr($print, 0, -2);
                ?>
            </p>
            <section class="flex flex-row two-button-row">
                <button id="cancel-btn" class="dark-btn cancel-btn">Cancel</button>
                <button id="continue-btn" class="dark-btn warn-continue-btn">Continue</button>
            </section>
        </div>
    </div>
</div>

<div id="file-upload-container" class="border main-container v-center flex-gap responsive-container">
    <form id="student-csv-upload-form" class="border main-container flex flex-column" action="/upload_student_csv"
          method="post" enctype="multipart/form-data">
        <input id="file-input-field" type="file" name="file" id="file" accept=".csv" hidden>
        <h3 class="page-header">Student Accounts</h3>
        <button type="button" class="x-dark-btn">
            <div id="file-upload-button" class="flex v-center">
                <p id="upload-file-text" onclick='upload_stu_csv()'>Upload Student Details file here</p>
                <i class="fa fa-upload upload-icon" aria-hidden="true"></i>
            </div>
        </button>

        <h4 class="csv-header-text">CSV Header Columns Format:</h4>
        <p class="csv-header-format flex v-center h-center">The CSV file should include reg_no, index_no, first_name,
            last_name, degree_program_code, date_joined respectively</p>
    </form>

<!--    <!--Search bar-->-->
<!--    <div class="flex h-center">-->
<!--        <div class="flex">-->
<!--            <input type="search" class="search-bar-account_creation input" placeholder="Search" >-->
<!--        </div>-->
<!--        <div class="flex v-center">-->
<!--            <span><button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button></span>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <!--Display profile-->-->
<!--    <div class="border main-container flex flex-column">-->
<!--        <div class="flex h-center v-center flex-responsive">-->
<!--            <div>-->
<!--                <h3 class="text-center">Kavindu Fernando</h3>-->
<!--                <h4 class="text-center text-normal line-height">Student</h4>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="flex h-justify flex-responsive margin-top">-->
<!--            <div class="border main-container responsive-container flex user-details h-center">-->
<!---->
<!--                <!-- User details -->-->
<!--                <form id="profile" action="/profile" method="post" enctype="multipart/form-data" class="width-full">-->
<!--                    <h5 class="text-center">User Details</h5><br>-->
<!--                    <div class="flex flex-wrap v-center h-center">-->
<!--                        <img id="preview" src="images/profile.png" alt="profile" class="profile_img profile_img_center"><br>-->
<!--                    </div>-->
<!--                    <div class="margin-top flex flex-column">-->
<!--                        <label class="margin-top">Registration Number</label>-->
<!--                        <div class="flex flex-responsive">-->
<!--                            <input type="text" value="2020/IS/0051" class="input text-right width-full"-->
<!--                                   readonly><br>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="margin-top flex flex-column">-->
<!--                        <label class="margin-top">Index Number</label>-->
<!--                        <div class="flex flex-responsive">-->
<!--                            <input type="text" value="21000051" class="input text-right width-full"-->
<!--                                   readonly><br>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="margin-top flex flex-column">-->
<!--                        <label class="margin-top">Email</label>-->
<!--                        <div class="flex flex-responsive">-->
<!--                            <input type="text" id="email" value="2020is0051@fusion.ac.lk"-->
<!--                                   class="input text-right width-full" readonly>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="margin-top">-->
<!--                        <div class="flex flex-row h-justify flex-end">-->
<!--                            <label class="margin-top">Contact Number</label>-->
<!--                            <div class="hide inline" id="edit-icon_1">-->
<!--                                <i class="fa-solid fa-pen edit-icon"></i>-->
<!--                            </div></div>-->
<!--                        <div class="flex flex-responsive">-->
<!--                            <input type="text" name="contact" id="contact" value="752678334"-->
<!--                                   class="input text-right width-full" readonly>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="margin-top">-->
<!--                        <div class="flex flex-row h-justify flex-end">-->
<!--                            <label class="margin-top">Personal Email</label>-->
<!--                            <div class="hide inline" id="edit-icon_2">-->
<!--                                <i class="fa-solid fa-pen edit-icon"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="flex flex-responsive">-->
<!--                            <input type="text" name="personal_email" id="personal_email"-->
<!--                                   value="fernandok@gmail.com" class="input text-right width-full" readonly>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flex margin-top-btn h-center">-->
<!--                        <button id="edit_profile" type="button" class="edit-btn edit-btn-text">-->
<!--                            Edit profile&nbsp;&nbsp;<i class="fa-solid fa-pen"></i>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </form>-->
<!---->
<!--                <!--edit profile - Modal-->-->
<!--                <div id="modal" class="modal" >-->
<!--                    <div class="modal-content">-->
<!--                        <span class="close">&times;</span>-->
<!--                        <form>-->
<!--                            <div class="margin-top flex flex-column">-->
<!--                                <label class="margin-top">Email</label>-->
<!--                                <div class="flex flex-responsive">-->
<!--                                    <input type="text" name="email" class="input text-right width-full" value="2020is0051@fusion.ac.lk"><br>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="margin-top flex flex-column">-->
<!--                                <label class="margin-top">Contact Number</label>-->
<!--                                <div class="flex flex-responsive">-->
<!--                                    <input type="text" name="contact_number" class="input text-right width-full" value="752678334"><br>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="margin-top flex flex-column">-->
<!--                                <label class="margin-top">Personal Email</label>-->
<!--                                <div class="flex flex-responsive">-->
<!--                                    <input type="text" name="personal_email" class="input text-right width-full" value="fernandok@gmail.com"><br>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="flex flex-row h-end">-->
<!--                                <button id="cancel_modal" class="flex confirm-btn half-width margin-top h-center v-center flex-responsive btn-cancel">Cancel</button>-->
<!--                                <button id="confirm_modal" class="flex confirm-btn half-width margin-top h-center v-center flex-responsive btn-confirm">Confirm</button>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <!--Login Activity-->-->
<!--            <div class="flex flex-column width-full">-->
<!--                <div class="border main-container flex flex-column flex-responsive">-->
<!--                    <h5 class="text-left">Login Activity</h5><br>-->
<!--                    <label class="text-normal">Last Login Date : Wednesday, February 08, 2023 | 08:50</label><br><br>-->
<!---->
<!--                    <label class="text-normal">Last Login Date : Wednesday, February 08, 2023 | 08:50</label><br>-->
<!--                </div>-->
<!---->
<!--                <!--Registered Courses-->-->
<!--                <div class="border main-container flex flex-column full-height flex-responsive">-->
<!--                    <h5>Registered Courses</h5><br>-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <td>IS 2001</td>-->
<!--                            <td>Programming using C</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>IS 2002</td>-->
<!--                            <td>Rapid Application Development</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>IS 2003</td>-->
<!--                            <td>Laboratory II</td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>

<script>
    modal_cancel("warn-modal");

    function upload_stu_csv() {
        let input = document.getElementById('file-input-field');
        input.onchange = e => {
            let file = Array.from(input.files);
            document.getElementById('upload-file-text').innerText = 'File Name: ' + file[0]['name'];
            document.getElementsByClassName('upload-icon')[0].addEventListener('click', function () {
                document.getElementById('student-csv-upload-form').submit();
            });
        }
        input.click();
    }

    function modal_update_continue(modal_id) {
        const modal = document.getElementById(modal_id);
        // click cancel button to close
        const continue_btn = modal.getElementsByClassName('continue-btn')[0];
        continue_btn.onclick = function () {
            modal.hidden = true;

        };

        // click outside the modal to close
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.hidden = true;
            }
        });
    }

    var modal = document.getElementById("modal");
    var btn = document.getElementById("edit_profile");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function (){
        modal.style.display = "block";
    }
    span.onclick = function (){
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
    cancel_modal.onclick = function(){
        modal.style.display = "none";
    }
</script>