<link rel="stylesheet" href="css/profile.css">
<script src="js/profile.js" defer></script>
<script src="js/validation.js" defer></script>

<?php
if(isset($mssg)) { ?>
    <div id="mssg-modal" class="<?php if ($mssg == 'ERROR') echo "error-mssg"; else echo "success-mssg";?> text-justify">
        <p><?php
            if ($mssg == 'ERROR') {
                echo "Invalid password.";
            } else {
                echo $mssg . " updated successfully.";
            }
            ?>
        </p>
    </div>
<?php } ?>

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

    <div class="flex h-justify flex-responsive block">
        <form id="profile" action="/profile" method="post" enctype="multipart/form-data" class="flex h-justify flex-responsive">
            <div class="border main-container v-center flex-gap responsive-container flex user-details h-center flex-column">

                <!-- User profile image -->
                    <div class="flex flex-column width-full">
                        <h5 class="text-center">User Details</h5><br>

                        <div class="flex flex-wrap v-center h-center width-full">
                            <img id="preview" src="<?php
                            $userRegNo = str_replace('/', '', $user->getRegNo());
                            $result = glob("./User Uploads/Profiles/{$userRegNo}.*");
                            if(sizeof($result) > 0)
                                $profilePicture = $result[0];
                            else
                                $profilePicture = "images/profile.png";
                            echo $profilePicture;
                            ?>" alt="profile" class="profile-img-admin"><br>

                            <input type="file" id="image_upload" class="hide" name="profile_picture" accept=".jpg, .jpeg, .png"
                                   onchange="previewImage(this)">
                            <button type="button" id= "profile-btn" class="edit-btn edit-btn-icon profile-btn hide">
                                <i class="fa-solid fa-camera"></i></button><br>
                        </div>
                    </div>
                    <div class="flex margin-top-btn h-center width-full">
                        <button id="password" type="button" class="edit-btn edit-btn-text">Change Password</button>
                        <button id="edit" type="button" class="edit-btn edit-btn-icon">
                            <i class="fa-solid fa-pen"></i>
                        </button><br>
                        <button id="btn_confirm" type="submit" class="confirm-btn edit-btn-text" hidden>Confirm</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--    Change password modal-->
    <div id="modal" class="modal" hidden>
        <div class="modal-content">
            <form action="/profile" method="post" name="change_password" onsubmit="return isValid()">
                <div class="margin-top flex flex-column">
                    <label class="margin-top">Existing Password</label>
                    <div class="flex flex-responsive">
                        <input type="password" name="password" class="input text-right width-full"><br>
                    </div>
                </div>
                <div id="password_error" class="error-message">
                    <input type="hidden" id="invalid_error_message" value="<?php echo $mssg == 'ERROR' ? 'Invalid password' : ''; ?>">
                </div>
                <div class="margin-top flex flex-column">
                    <label class="margin-top">New Password</label>
                    <div class="flex flex-responsive">
                        <input type="password" name="new_password" class="input text-right width-full" id="new_password">
                        <br>
                    </div>
                </div>
                <div id="new_password_error" class="error-message">
                </div>
                <div class="margin-top flex flex-column">
                    <label class="margin-top">Confirm Password</label>
                    <div class="flex flex-responsive">
                        <input type="password" name="confirm_password" class="input text-right width-full"><br>
                    </div>
                </div>
                <div id="error" class="error-message">
                    <?php if (isset($error)) echo $error; ?>
                </div>
                <p><b>Hint:</b><br> The password should be at least 8 characters long which contains uppercase
                    letters, lowercase letters, numbers, and special characters</p>
                <div class="flex flex-row h-end">
                    <button type="button" id="cancel_modal" class="flex half-width margin-top h-center v-center flex-responsive cancel-btn btn-border-green">Cancel</button>
                    <button type="submit" id="confirm_modal" class="flex confirm-btn half-width margin-top h-center v-center flex-responsive btn-confirm">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    <?php }?>

<!--Warn Modals-->
<div id="warn-modal-contact" class="modal" hidden>
    <div id="warn_msg_email" class="modal-content warn-modal-content" >
        <div class="flex flex-column v-center h-center">
            <img src="images/primary_icons/warning.svg">
            <h4 id="delete-warning">Invalid contact number</h4>
            <div>
                <p>Please enter a valid contact number in one of the following formats,</p>
                <ul>
                    <li>Starts with a "+" sign followed by exactly 11 digits</li>
                    <li>Consists of exactly 10 digits</li>
                </ul>
            </div>
            <section class="flex flex-row two-button-row">
                <button id="continue-btn" class="dark-btn cancel-btn warn-continue-btn">OK</button>
            </section>
        </div>
    </div>
</div>

<div id="warn-modal-email" class="modal" hidden>
    <div id="warn_msg_email" class="modal-content warn-modal-content" >
        <div class="flex flex-column v-center h-center">
            <img src="images/primary_icons/warning.svg">
            <h4 id="delete-warning">Invalid Email</h4>
            <div>
                <p>Please enter a valid email address following formats,</p>
                <ul>
                    <li>Starts with one or more characters</li>
                    <li>Followed by the "@" symbol </li>
                    <li>Followed by one or more characters</li>
                    <li>Followed by a dot symbol (.)</li>
                    <li>Ends with one or more characters </li>
                </ul>            </div>
            <section class="flex flex-row two-button-row">
                <button id="continue-btn" class="dark-btn cancel-btn warn-continue-btn">OK</button>
            </section>
        </div>
    </div>
</div>


