<?php 
   include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add student</title>
    <link rel="stylesheet" href="css/form.css">

</head>
<body>
    <div class="container">
        <br>
        <h4 class="back"><a href="student_view.php">Back</a></h4>
        <div class="wrapper">
            <h4>Add Student</h4>

            <div class="form">
                <form action="crud.php" method="POST">
                <div class="input-field">
                    <label>* First Name</label><br>
                    <input type="text" name="f_name" class="input" pattern="[a-zA-Z]+" required placeholder="Sanduni"><br><br>
                </div>

                <div class="input-field">
                    <label>* Last Name</label><br>
                    <input type="text" name="l_name" class="input" pattern="[a-zA-Z]+" required placeholder="Perera"><br><br>
                </div>

                <div class="input-field">
                    <label>* Index Number</label><br>
                    <input type="text" name="index" class="input" required pattern="[0-9]+" maxlength="8" placeholder="20000000"><br><br>
                </div>

                <div class="input-field">
                    <label>* Registration No</label><br>
                    <input type="text" name="reg" class="input" maxlength="12" required placeholder="2020/CS/001"><br><br>
                </div>

                <div class="input-field">
                    <label>* University Email</label><br>
                    <input type="text" name="email" class="input" pattern=".+@fusion\.ac\.lk" required placeholder="2020cs0000@fusion.ac.lk"><br><br>
                </div>

                <div class="input-field">
                    <label>Contact Number</label><br>
                    <input type="text" name="contact" class="input" pattern="0.+" maxlength="10" minlength="10" placeholder="0718235648"><br><br>
                </div>

                <div class="input-field">
                    <label>Personal Email</label><br>
                    <input type="text" name="personal_email" class="input" pattern=".+@gmail\.com" placeholder="sanduni@gmail.com"><br><br>
                </div>

                <div class="input-field">
                    <label>* Password</label><br>
                    <input type="password" name="pass" class="input" required><br><br>
                </div>

                <div class="input-field">
                    <label>Degree Program</label><br>
                    <select name="degree" class="input" required>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Systems">Information Systems</option>
                    </select>
                </div>
                <div class="input-field">
                    <button type="submit" name="save_student" class="btn">Add Student</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    
</body>
</html>