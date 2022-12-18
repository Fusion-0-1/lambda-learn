<?php 

    require('connection.php');
    require('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit student</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<div class="container">
    <?php
        include("message.php");
    ?>
    <div class="wrapper">
        <h4>Edit Student </h4>
        <div class="form">
            <?php 
    
                if(isset($_GET['id'])){
                    $student_id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "SELECT * FROM student WHERE reg_no='$student_id' ";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result)>0){
                        $stu = mysqli_fetch_array($result);

                        ?>

                            <form action="crud.php" method="POST">

                                <div class="input-field">
                                <label>University Email</label><br>
                                <input type="text" name="email" value="<?= $stu['email']?>" class="input"><br><br>   
                                </div>

                                <div class="input-field">
                                <label>Contact Number</label><br>
                                <input type="number" name="contact" value="<?= $stu['contact_no']?>" class="input"><br><br>
                                </div>

                                <div class="input-field">
                                <label>Personal Email</label><br>
                                <input type="text" name="personal_email" value="<?= $stu['personal_email']?>" class="input"><br><br>
                                </div>

                                <div class="input-field align">
                                <button type="submit" name="update_student" class="btn-green">Update</button>
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
    </div>
</div>

    

    

    

    
</body>
</html>