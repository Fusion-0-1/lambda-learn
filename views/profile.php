<link rel="stylesheet" href="css/profile.css">

<div class="border main-container v-center flex-gap responsive-container">
    <div class="flex h-center v-center flex-responsive">
        <div>
            <h2 class="text-center"><?php echo $firstName." ".$lastName ?></h2>
            <h3 class="text-center text-normal line-height">Student</h3>
        </div>
        <div>
            <!--                <button class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>-->
        </div>

    </div>
    <div class="flex h-center flex-gap flex-responsive">
        <div class="border main-container flex-gap">
            <!-- User details -->

            <h3 class="text-center">User Details</h3>

            <img src="images/profile.png" alt="profile" class="profile_img profile_img_center"><br>

            <div class="margin-top">
                <label class="margin-top">Index Number</label> <br>
                <div class="flex flex-responsive">
<!--                    TODO: Hide index number field for other users-->
                    <input type="text" value="<?php echo $indexNo?>" class="input text-right width-full" readonly><br>
                </div>
            </div>


            <div class="margin-top">
                <label class="margin-top">Registration Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?php echo $regNo?>" class="input text-right width-full" readonly><br>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" id="email" value="<?php echo $email?>" class="input text-right width-full" readonly>
                    <!--                        <button class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>-->
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Contact Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" id="contact" value="<?php echo $contactNo?>" class="input text-right width-full" readonly>
                    <!--                        <button class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>-->
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Personal Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" id="personal_email" value="<?php echo $personalEmail?>" class="input text-right width-full" readonly>
                    <!--                        <button class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>-->
                </div>
            </div>
            <div class="flex margin-top h-center">
                <button id="password" class="edit-btn edit-btn-text width-full">Change Password</button>
                <button id="edit" class="edit-btn edit-btn-icon"><i class="fa-solid fa-pen"></i></button><br>
            </div>
        </div>

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
                    <button class="flex confirm-btn margin-top h-center v-center flex-responsive">Confirm</button>
                </form>
            </div>
        </div>

        <div class="flex-wrap">
            <div class="border main-container flex-gap">
                <!--Login Activity-->
                <h3>Login Activity</h3>
                <h4 class="text-normal text-center"><?php echo $lastLogin?></h4>
                <h4 class="text-normal text-center"><?php echo $lastLogout?></h4>
            </div>
            <div class="border main-container flex-gap">
                <!--Registered Courses-->
                <h3>Registered Courses</h3>
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

    btn.onclick = function(){
        document.getElementById('email').removeAttribute('readonly');
        document.getElementById('contact').removeAttribute('readonly');
        document.getElementById('personal_email').removeAttribute('readonly');
    }
</script>

