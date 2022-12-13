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
    <title>View student</title>
    <link rel="stylesheet" href="css/view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">


</head>
<body>
    <h2>Student Details</h2>
    <div class="header">
    <h1> </h1>
    <button class="add-new"><a href="student_add.php" class="link">Add Student</a></button>
    </div>

    <br>
    
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Index Number</th>
                    <th>Registration Number</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $query = "SELECT f_name, l_name, index_no, reg_no FROM student";
                    $result = mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($result)>0){
                        foreach($result as $stu){
                            ?>
                                <tr>
                                    <td><?= $stu['f_name']." ".$stu['l_name']; ?></td>
                                    <td><?= $stu['index_no']; ?></td>
                                    <td><?= $stu['reg_no']; ?></td>
                                    
                                    <td class="inline">
                                        <button class="btn-view"><a href="student_profile.php?id=<?=$stu['reg_no']?>" class="link"><i class="fa-solid fa-eye"></i></a></button>

                                        <button class="btn-edit"><a href="student_edit.php?id=<?=$stu['reg_no']?>" class="link"><i class="fa-solid fa-pen-to-square"></i></a></button>

                                        <form action="crud.php" method="POST">
                                            <button type="submit" name="delete_student" value="<?=$stu['reg_no']?>" class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                    else{
                        echo "<h5>No results found</h5>";
                    }
                ?>
            </tbody>
        </table>

    </div>

    
</body>
</html>