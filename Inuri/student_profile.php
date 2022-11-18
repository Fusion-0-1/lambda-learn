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

    <h4>
        <a href="student_view.php">BACK</a>
    </h4>

    <?php 
    
        if(isset($_GET['id'])){
            $stu_reg_no = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT * FROM student WHERE reg_no='$stu_reg_no' ";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result)>0){
                $stu = mysqli_fetch_array($result);

                ?>
                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="card">
                                <h2><?=$stu['name']?></h2><br><br>
                                    <label class="heading">Index Number</label><br>
                                    <p class="content card-1"><?= $stu['index_no']?></p><br>

                                    <label class="heading">Registration Number</label><br>
                                    <p class="content card-1"><?= $stu['reg_no']?></p><br>

                                    <label class="heading">Email</label><br>
                                    <p class="content card-1"><?= $stu['email']?></p><br>

                                    <label class="heading">Contact Number</label><br>
                                    <p class="content card-1"><?= $stu['contact_no']?></p><br>

                                    <label class="heading">Personal Email</label><br>
                                    <p class="content card-1"><?= $stu['personal_email']?></p><br>

                                    <label class="heading">Degree Program</label><br>
                                    <p class="content card-1"><?= $stu['degree_programme']?></p><br>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                        
                        <!-- add a profile picture here -->

                <?php
            }
            else{
                echo "<h5>No such ID found</h5>";
            }
        }
    
    ?>

    
</body>
</html>