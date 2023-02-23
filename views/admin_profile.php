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
    <?php
    if ($_SESSION['user-role'] == 'Admin') {?>
    <div class="flex h-justify flex-responsive">
        <div class="border main-container v-center flex-gap responsive-container flex user-details h-center">

            <!-- User profile image -->
            <form id="profile" action="/profile" method="post" enctype="multipart/form-data" class="width-full">

                <div class="flex flex-column ">
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


                    <div class="flex margin-top-btn h-center">
                        <button id="password" type="button" class="edit-btn edit-btn-text">Change Password</button>
                        <button id="edit" type="button" class="edit-btn edit-btn-icon">
                            <i class="fa-solid fa-pen"></i>
                        </button><br>
                        <button id="btn_confirm" type="submit" class="confirm-btn edit-btn-text hide">Confirm</button>
                    </div>
                </div>

            <!--Change password - Modal-->
            <div id="modal" class="modal" >
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


            <!--User details-->
            <div class="border main-container v-center flex-gap full-height flex-row">
                <div class="flex h-evenly">
                    <div class="margin-top flex flex-column">
                        <label class="margin-top">Registration Number</label>
                        <div class="flex flex-responsive">
                            <input type="text" value="<?php echo $user->getRegNo()?>" class="input text-right width-full"
                                   readonly><br>
                        </div>
                    </div>

                    <div class="margin-top flex flex-column">
                        <label class="margin-top">Email</label>
                        <div class="flex flex-responsive">
                            <input type="text" id="email" value="<?php echo $user->getEmail()?>"
                                   class="input text-right width-full" readonly>
                        </div>
                    </div>
                </div>

                <div class="flex h-evenly">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>

<!--Scripts-->
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

    // Function to confirm changes to contact and personal email fields
    btn_confirm.onclick = function (){
        btn_confirm.classList.add('hide');
        btn.classList.remove('hide');
        btn_edit.classList.remove('hide');
        document.getElementById('contact').setAttribute('readonly', true);
        document.getElementById('personal_email').setAttribute('readonly', true);
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
</script>


