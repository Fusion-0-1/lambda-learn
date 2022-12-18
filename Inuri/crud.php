<?php
    session_start();
    include("connection.php");

    //Delete Student
    if(isset($_POST['delete_student'])){
        $student_id = $_POST['delete_student'];

        $query = "DELETE FROM student WHERE reg_no='$student_id' ";
        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['message'] = "Student deleted successfilly!!";
            header("location: student_view.php");
            exit(0);
        }
        else{
            $_SESSION['message'] = "Failed to delete";
            header("location: student_view.php");
            exit(0);
        }

    }

    
    //update student
    if(isset($_POST['update_student'])){
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $personal_email = $_POST['personal_email'];

        $query = "UPDATE student SET email='$email', contact_no='$contact', personal_email='$personal_email'";
        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['message'] = "Student Updated successfilly!!";
            header("location: student_view.php");
            exit(0);
        }
        else{
            $_SESSION['message'] = "Failed to Update student";
            header("location: student_view.php");
            exit(0);
        }
    }

    //create student
    if(isset($_POST['save_student'])){
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $index = $_POST['index'];
        $reg = $_POST['reg'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $personal_email = $_POST['personal_email'];
        $password = $_POST['pass'];
        $degree = $_POST['degree'];

        $query = "INSERT INTO student(f_name, l_name, index_no, reg_no, email, contact_no, personal_email, password, degree_programme) VALUES 
            ('$f_name','$l_name', '$index', '$reg', '$email', '$contact', '$personal_email', '$password', '$degree')";

        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['message'] = "Student created successfully!!";
            header("location: student_add.php");
            exit(0);
        }
        else{
            $_SESSION['message'] = "Failed add Student";
            header("location: student_add.php");
            exit(0);
        }
    }
?>