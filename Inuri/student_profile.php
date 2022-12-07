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
    <link rel="stylesheet" href="css/form.css">

</head>
<body>
    <div class="container wrapper">
        <?php

        if(isset($_GET['id'])){
        $stu_reg_no = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM student WHERE reg_no='$stu_reg_no' ";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result)>0){
        $stu = mysqli_fetch_array($result);

        ?>
            <h4><?=$stu['name']?></h4><br><br>

            <form class="form">
                <div class="input-field">
                    <label>Index Number</label><br>
                    <input type="text" value="<?= $stu['index_no']?>" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Registration Number</label><br>
                    <input type="text" value="<?= $stu['reg_no']?>" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Email</label><br>
                    <input type="text" value="<?= $stu['email']?>" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Contact Number</label><br>
                    <input type="text" value="<?= $stu['contact_no']?>" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Personal Email</label><br>
                    <input type="text" value="<?= $stu['personal_email']?>" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Degree Program</label><br>
                    <input type="text" value="<?= $stu['degree_programme']?>" class="input"><br><br>
                </div>
            </form>
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