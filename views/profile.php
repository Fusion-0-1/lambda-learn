<link rel="stylesheet" href="css/profile.css">

<div class="border main-container v-center flex-gap responsive-container">
    <div class="flex h-center v-center flex-responsive">
        <div>
            <h2 class="text-center"><?php echo $user->getFirstName()." ".$user->getLastName() ?></h2>
            <h3 class="text-center text-normal line-height">
                <?php
                $reg_split = explode("/", $user->getRegNo());
                $position = strtolower($reg_split[1]);
                if($position === 'cs' or 'is')
                    echo "Student";
                elseif ($position === 'lc')
                    echo "Lecturer";
                else
                    echo "Administrator";
                ?>
            </h3>
        </div>
    </div>

    <div class="flex h-justify">
        <div class="border main-container v-center flex-gap flex-responsive responsive-container flex user-details h-center">
            <form id="profile" action="/profile" method="post" enctype="multipart/form-data" class="width-full">
                <!-- User details -->

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

                    <input type="file" id="image_upload" class="hide" name="profile_picture" accept=".jpg, .jpeg, .png" onchange="previewImage(this)">
                    <button type="button" id= "profile-btn"class="edit-btn edit-btn-icon profile-btn hide"><i class="fa-solid fa-camera"></i></button><br>
                </div>

                <div class="margin-top flex flex-column">
                    <label class="margin-top">Registration Number</label>
                    <div class="flex flex-responsive">
                        <input type="text" value="<?php echo $user->getRegNo()?>" class="input text-right width-full" readonly><br>
                    </div>
                </div>

                <div class="margin-top flex flex-column">
                    <label class="margin-top">Index Number</label>
                    <div class="flex flex-responsive">
                        <!--                    TODO: Hide index number field for other users-->
                        <input type="text" value="<?php echo $user->getIndexNo()?>" class="input text-right width-full" readonly><br>
                    </div>
                </div>

                <div class="margin-top flex flex-column">
                    <label class="margin-top">Email</label>
                    <div class="flex flex-responsive">
                        <input type="text" id="email" value="<?php echo $user->getEmail()?>" class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="margin-top">
                    <div class="flex flex-row h-justify flex-end">
                        <label class="margin-top">Contact Number</label>
                        <div class="hide inline" id="edit-icon_1">
                            <i class="fa-solid fa-pen edit-icon"></i>
                        </div></div>
                    <div class="flex flex-responsive">
                        <input type="text" name="contact" id="contact" value="<?php echo $user->getContactNo()?>"
                               class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="margin-top">
                    <div class="flex flex-row h-justify flex-end"><label class="margin-top">Personal Email</label><div class="hide inline" id="edit-icon_2"><i class="fa-solid fa-pen edit-icon"></i></div></div>
                    <div class="flex flex-responsive">
                        <input type="text" name="personal_email" id="personal_email" value="<?php echo $user->getPersonalEmail()?>" class="input text-right width-full" readonly>
                    </div>
                </div>

                <div class="flex margin-top-btn h-center">
                    <button id="password" type="button" class="edit-btn edit-btn-text">Change Password</button>
                    <button id="edit" type="button" class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>
                    <button id="btn_confirm" type="submit" class="confirm-btn edit-btn-text hide">Confirm</button>
                </div>
            </form>

            <div id="modal" class="modal" >
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form>
                        <div class="margin-top">
                            <label>Existing Password</label><br>
                            <input type="password" name="password" class="input text-right width-full">
                        </div>
                        <div class="margin-top">
                            <label>New Password</label><br>
                            <input type="password" name="password" class="input text-right width-full">
                        </div>
                        <div class="margin-top">
                            <label>Confirm Password</label><br>
                            <input type="password" name="password" class="input text-right width-full">
                        </div>
                        <button class="flex confirm-btn half-width margin-top h-center v-center flex-responsive">Confirm</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="flex flex-column width-full">
            <div class="border main-container v-center flex-gap responsive-container text-center">
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


            <div class="border main-container v-center flex-gap responsive-container full-height">
                <!--Registered Courses-->
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
        </div>
    </div>
</div>

<script>
    var modal = document.getElementById("modal");
    var btn = document.getElementById("password");
    var span = document.getElementsByClassName("close")[0];
    var btn_edit = document.getElementById("edit");
    var btn_confirm = document.getElementById("btn_confirm");
    var change_profile_btn = document.getElementById('profile-btn');

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

    btn_confirm.onclick = function (){
        btn_confirm.classList.add('hide');
        btn.classList.remove('hide');
        btn_edit.classList.remove('hide');
        document.getElementById('contact').setAttribute('readonly', true);
        document.getElementById('personal_email').setAttribute('readonly', true);
    }

    change_profile_btn.onclick = function(){
        document.getElementById("image_upload").click();
    }

    function previewImage(input) {
        var preview = document.getElementById("preview");
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (event) {
                preview.src = event.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

