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
        <div class="wrapper">
            <h4>Add Student</h4>

            <div class="form">
                <form action="crud.php" method="POST">
                <div class="input-field">
                    <label>Name</label><br>
                    <input type="text" name="name" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Index Number</label><br>
                    <input type="number" name="index" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Registration Number</label><br>
                    <input type="text" name="reg" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Email</label><br>
                    <input type="text" name="email" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Contact Number</label><br>
                    <input type="number" name="contact" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Personal Email</label><br>
                    <input type="text" name="personal_email" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Password</label><br>
                    <input type="text" name="pass" class="input"><br><br>
                </div>

                <div class="input-field">
                    <label>Degree Program</label><br>
                    <input type="text" name="degree" class="input"><br><br>
                </div>
                <div class="input-field">
                    <button type="submit" name="save_student" class="btn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    
</body>
</html>