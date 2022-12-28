<link rel="stylesheet" href="css/profile.css">

<div class="border main-container v-center flex-gap responsive-container">
    <div class="flex h-center v-center flex-responsive">
        <div>
            <h2 class="text-center"><?php echo $user->getFirstName()." ".$user->getLastName() ?></h2>
            <h3 class="text-center text-normal line-height">Student</h3>
        </div>

    </div>
    <div class="flex h-center flex-gap flex-responsive">
        <form id="profile" action="/profile" method="post" class="border main-container flex-gap">
            <!-- User details -->

            <h5 class="text-center">User Details</h5>

            <img src="images/profile.png" alt="profile" class="profile_img profile_img_center"><br>


            <div class="margin-top">
                <label class="margin-top">Registration Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?php echo $user->getRegNo()?>" class="input text-right width-full" readonly><br>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Index Number</label> <br>
                <div class="flex flex-responsive">
<!--                    TODO: Hide index number field for other users-->
                    <input type="text" value="<?php echo $user->getIndexNo()?>" class="input text-right width-full" readonly><br>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" id="email" value="<?php echo $user->getEmail()?>" class="input text-right width-full" readonly>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Contact Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" name="contact" id="contact" value="<?php echo $user->getContactNo()?>" class="input text-right width-full" readonly>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Personal Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" name="personal_email" id="personal_email" value="<?php echo $user->getPersonalEmail()?>" class="input text-right width-full" readonly>
                </div>
            </div>
            <div class="flex margin-top h-center">
                <button id="password" type="button" class="edit-btn edit-btn-text width-full">Change Password</button>
                <button id="edit" type="button" class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>
                <button id="btn_confirm" type="submit" class="confirm-btn edit-btn-text width-full hide">Confirm</button>
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

        <div class="flex-wrap">
            <div class="border main-container flex-gap">
                <!--Login Activity-->
                <h3>Login Activity</h3>
                <h4 class="text-normal text-center"><?php echo $user->getLastLogin()?></h4>
                <h4 class="text-normal text-center"><?php echo $user->getLastLogout()?></h4>
            </div>
            <div class="border main-container flex-gap">
                <!--Registered Courses-->
                <h5>Registered Courses</h5>
                <table>
                    <tr>
                        <td>SCS2201</td>
                        <td>Data Structures and Algorithms III</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Rapid Application Development</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Mathematical Methods</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Software Engineering III</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Computer Networks</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Functional Programming</td>
                    </tr>
                    <tr>
                        <td>SCS2201</td>
                        <td>Programming Language Concepts</td>
                    </tr>
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
</script>

