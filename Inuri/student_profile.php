<?php 

    require('connection.php');
    include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/profile.css">

</head>
<body>

<div class="border main-container v-center flex-gap responsive-container">
    <?php

    if(isset($_GET['id'])){
    $stu_reg_no = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM student WHERE reg_no='$stu_reg_no' ";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result)>0){
    $stu = mysqli_fetch_array($result);

    ?>
    <div class="flex h-center v-center flex-responsive">
        <div>
            <h2 class="text-center"><?=$stu['f_name']." ".$stu['l_name']?></h2>
            <h3 class="text-center text-normal line-height">Student</h3>
        </div>

    </div>
    <div class="flex h-center flex-gap flex-responsive">
        <div class="border main-container flex-gap">
            <!-- User details -->

            <h3 class="text-center">User Details</h3>


            <div class="margin-top">
                <label class="margin-top">Index Number</label> <br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['index_no']?>" class="input text-right width-full"><br>
                </div>
            </div>


            <div class="margin-top">
                <label class="margin-top">Registration Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['reg_no']?>" class="input text-right width-full"><br>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['email']?>" class="input text-right width-full">
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Contact Number</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['contact_no']?>" class="input text-right width-full">
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Personal Email</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['personal_email']?>" class="input text-right width-full"><br>
                </div>
            </div>

            <div class="margin-top">
                <label class="margin-top">Degree Program</label><br>
                <div class="flex flex-responsive">
                    <input type="text" value="<?= $stu['degree_programme']?>" class="input text-right width-full"><br>
                </div>
            </div>

            <div class="flex margin-top h-center">
                <br><br><button class="edit-btn edit-btn-text width-full"><a href="student_edit.php?id=<?=$stu['reg_no']?>">Edit Profile <i class="fa-solid fa-pen"></i></a></button>
            </div>
        </div>

        <div class="flex-wrap">
            <div class="border main-container flex-gap">
                <!--Login Activity-->
                <h3>Login Activity</h3><br>
                <h4 class="text-normal text-center">Last Login</h4>
                <h4 class="text-normal text-center">Last Logout</h4>
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
    <?php
    }
    else{
        echo "<h5>No such ID found</h5>";
    }
    }

    ?>
    </div>
</body>
</html>