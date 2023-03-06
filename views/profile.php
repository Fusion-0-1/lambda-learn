<link rel="stylesheet" href="css/profile.css">

<div class="border main-container v-center flex-gap responsive_main-container">
    <div class="flex h-center v-center flex-responsive">
        <div>
            <h2 class="text-center"><?php use app\core\User;
                echo $user->getFirstName()." ".$user->getLastName() ?></h2>
            <h3 class="text-center text-normal line-height">
                <?php echo User::getUserType($user->getRegNo()); ?>
            </h3>
        </div>
    </div>

    <div class="flex h-justify flex-responsive">
        <div class="border main-container v-center flex-gap responsive-container flex user-details h-center">

            <!-- User details -->
            <form id="profile" action="/profile" method="post" enctype="multipart/form-data" class="width-full">

                <h5 class="text-center">User Details</h5><br>

                <div class="flex flex-wrap v-center h-center">
                    <img id="preview" src="<?php
                    $userRegNo = str_replace('/', '', $user->getRegNo());
                    $result = glob("./images/profile/{$userRegNo}.*");
                    if(sizeof($result) > 0)
                        $profilePicture = $result[0];
                    else
                        $profilePicture = "images/profile.png";
                    echo $profilePicture;
                    ?>" alt="profile" class="profile_img profile_img_center"><br>

                    <input type="file" id="image_upload" class="hide" name="profile_picture" accept=".jpg, .jpeg, .png"
                           onchange="previewImage(this)">
                    <button type="button" id= "profile-btn"class="edit-btn edit-btn-icon profile-btn hide">
                        <i class="fa-solid fa-camera"></i></button><br>
                </div>

                <div class="margin-top flex flex-column">
                    <label class="margin-top">Registration Number</label>
                    <div class="flex flex-responsive">
                        <input type="text" value="<?php echo $user->getRegNo()?>" class="input text-right width-full"
                               readonly><br>
                    </div>
                </div>

                <?php
                    if ($_SESSION['user-role'] == 'Student') {?>
                        <div class="margin-top flex flex-column">
                            <label class="margin-top">Index Number</label>
                            <div class="flex flex-responsive">
                                <input type="text" value="<?php echo $user->getIndexNo()?>" class="input text-right width-full"
                                       readonly><br>
                            </div>
                        </div>
                <?php }?>

                <div class="margin-top flex flex-column">
                    <label class="margin-top">Email</label>
                    <div class="flex flex-responsive">
                        <input type="text" id="email" value="<?php echo $user->getEmail()?>"
                               class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="margin-top">
                    <div class="flex flex-row h-justify flex-end">
                        <label class="margin-top">Contact Number</label>
                        <div class="hide inline" id="edit-icon_1">
                            <i class="fa-solid fa-pen edit-icon"></i>
                        </div>
                    </div>
                    <div class="flex flex-responsive">
                        <input type="text" name="contact" id="contact" value="<?php echo $user->getContactNo()?>"
                               class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="margin-top">
                    <div class="flex flex-row h-justify flex-end">
                        <label class="margin-top">Personal Email</label>
                        <div class="hide inline" id="edit-icon_2">
                            <i class="fa-solid fa-pen edit-icon"></i>
                        </div>
                    </div>
                    <div class="flex flex-responsive">
                        <input type="text" name="personal_email" id="personal_email"
                               value="<?php echo $user->getPersonalEmail()?>" class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="flex margin-top-btn h-center">
                    <button id="password" type="button" class="edit-btn edit-btn-text">Change Password</button>
                    <button id="edit" type="button" class="edit-btn edit-btn-icon">
                        <i class="fa-solid fa-pen"></i>
                    </button><br>
                    <button id="btn_confirm" type="submit" class="confirm-btn edit-btn-text hide">Confirm</button>
                </div>
            </form>


            <!--Change password - Modal-->
            <div id="modal" class="modal" hidden>
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form>
                        <div class="margin-top flex flex-column">
                            <label class="margin-top">Existing Password</label>
                            <div class="flex flex-responsive">
                                <input type="password" name="password" class="input text-right width-full"><br>
                            </div>
                        </div>
                        <div class="margin-top flex flex-column">
                            <label class="margin-top">New Password</label>
                            <div class="flex flex-responsive">
                                <input type="password" name="password" class="input text-right width-full"><br>
                            </div>
                        </div>
                        <div class="margin-top flex flex-column">
                            <label class="margin-top">Confirm Password</label>
                            <div class="flex flex-responsive">
                                <input type="password" name="password" class="input text-right width-full"><br>
                            </div>
                        </div>
                        <div class="flex flex-row h-end">
                            <button id="cancel_modal" class="flex confirm-btn half-width margin-top h-center v-center flex-responsive btn-cancel">Cancel</button>
                            <button id="confirm_modal" class="flex confirm-btn half-width margin-top h-center v-center flex-responsive btn-confirm">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--Login Activity-->
        <div class="flex flex-column width-full">
            <div class="border main-container v-center flex-gap text-center">
                <h5 class="text-left">Login Activity</h5><br>
                <label class="text-normal">
                    <?php
                    $utcTime = $user->getLastLogin();
                    $sriLankanTimezone = new DateTimeZone('Asia/Colombo');
                    $date = new DateTime($utcTime, new DateTimeZone('UTC'));
                    $date->setTimezone($sriLankanTimezone);
                    $sriLankanDateAndTime = $date->format('l, F d, Y | H:i');
                    echo 'Last Login Date : ' . $sriLankanDateAndTime;
                    ?>
                </label><br><br>
                <label class="text-normal">
                    <?php
                    $utcTime = $user->getLastLogout();
                    $sriLankanTimezone = new DateTimeZone('Asia/Colombo');
                    $date = new DateTime($utcTime, new DateTimeZone('UTC'));
                    $date->setTimezone($sriLankanTimezone);
                    $sriLankanDateAndTime = $date->format('l, F d, Y | H:i');
                    echo 'Last Logout Date : ' .$sriLankanDateAndTime;
                    ?>
                </label><br>
            </div>


<!--Registered Courses-->
            <?php
            if ($_SESSION['user-role'] == 'Student' or $_SESSION['user-role'] == 'Lecturer' or $_SESSION['user-role'] == 'Coordinator') {?>
                <div class="border main-container v-center flex-gap full-height">
                    <h5>Registered Courses</h5><br>
                    <table>
                        <?php
                        $unique_courses = array();
                        foreach ($courses as $course) {
                            $course_code = $course->getCourseCode();
                            if (!array_key_exists($course_code, $unique_courses)) {
                                $unique_courses[$course_code] = $course;
                            }
                        }
                        foreach ($unique_courses as $course) {
                            ?>
                            <tr>
                                <td><?php echo $course->getCourseCode()?></td>
                                <td><?php echo $course->getCourseName()?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            <?php }?>
        </div>
    </div>

</div>

<div id="warn-modal" class="modal hide" >
    <div id="warn_msg_email" class="modal-content warn-modal-content" >
        <div class="flex flex-column v-center h-center">
            <img src="images/primary_icons/warning.svg">
            <h4 id="delete-warning">Invalid Email</h4>
            <div>
                <p>Email should follow below format,</p>
                <ul>
                    <li>Must contain one or more non-whitespace characters</li>
                    <li>Cannot start or end with a period</li>
                    <li>One or more non-whitespace characters separated by a period (.)</li>
                    <li>Cannot start or end with a period</li>
                </ul>
            </div>
            <section class="flex flex-row two-button-row">
                <button id="continue-btn" class="dark-btn cancel-btn warn-continue-btn">OK</button>
            </section>
        </div>
    </div>
</div>

<!--Scripts-->
<script type="text/javascript" src="js/validation.js"></script>
<script>
    var modal = document.getElementById("modal");
    var btn = document.getElementById("password");
    var span = document.getElementsByClassName("close")[0];
    var btn_edit = document.getElementById("edit");
    var btn_confirm = document.getElementById("btn_confirm");
    var change_profile_btn = document.getElementById('profile-btn');
    var preview = document.getElementById("preview");
    var cancel_modal = document.getElementById("cancel_modal");
    var confirm_modal = document.getElementById("confirm_modal");


    btn.onclick = function (){
        modal.style.display = "block";
        modal.hidden = false;
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

    // Function to enable editing of contact and personal email fields
    btn_edit.onclick = function(){
        document.getElementById('contact').removeAttribute('readonly');
        document.getElementById('personal_email').removeAttribute('readonly');
        document.getElementById('edit-icon_1').classList.remove('hide');
        document.getElementById('edit-icon_2').classList.remove('hide');
        change_profile_btn.classList.remove('hide');
        btn_edit.classList.add('hide');
        btn.classList.add('hide');
        btn_confirm.classList.remove('hide');
    }

    document.getElementById('continue-btn').onclick = function (){
        btn_confirm.classList.add('hide');
        btn.classList.remove('hide');
        btn_edit.classList.remove('hide');
        document.getElementById('contact').setAttribute('readonly', true);
        document.getElementById('personal_email').setAttribute('readonly', true);
    }

    // Function to confirm changes to contact and personal email fields
    btn_confirm.onclick = function () {
        if (profile_validate( document.getElementById('contact').value,document.getElementById('personal_email').value)){
            btn_confirm.classList.add('hide');
            btn.classList.remove('hide');
            btn_edit.classList.remove('hide');
            document.getElementById('contact').setAttribute('readonly', true);
            document.getElementById('personal_email').setAttribute('readonly', true);
        }
        else{
            document.getElementById('warn-modal').style.display = "block";
            document.getElementById('warn-modal').hidden = false;
        }
    }

    // Function to trigger the image upload input field when the change profile button is clicked
    change_profile_btn.onclick = function(){
        document.getElementById("image_upload").click();
    }

    // Function to preview the selected image before uploading
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function profile_validate(contact, email){
        if (!validate_contact(contact)) {
            return false;
        }
        if (!validate_email(email)) {
            return false;
        }
        return true;
    }
</script>

