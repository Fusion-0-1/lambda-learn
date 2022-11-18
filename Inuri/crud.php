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

        $name = $_POST['name'];
        $index = $_POST['index'];
        $reg = $_POST['reg'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $personal_email = $_POST['personal_email'];
        $password = $_POST['pass'];
        $degree = $_POST['degree'];

        $query = "UPDATE student SET name='$name', index_no='$index', reg_no='$reg', email='$email', contact_no='$contact', personal_email='$personal_email', password='$password', degree_programme='$degree' WHERE reg_no='$reg' ";
        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['message'] = "Student updated successfilly!!";
            header("location: student_view.php");
            exit(0);
        }
        else{
            $_SESSION['message'] = "Failed to update student";
            header("location: student_view.php");
            exit(0);
        }
    }

    //create student
    if(isset($_POST['save_student'])){
        $name = $_POST['name'];
        $index = $_POST['index'];
        $reg = $_POST['reg'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $personal_email = $_POST['personal_email'];
        $password = $_POST['pass'];
        $degree = $_POST['degree'];

        $query = "INSERT INTO student(name, index_no, reg_no, email, contact_no, personal_email, password, degree_programme) VALUES 
            ('$name', '$index', '$reg', '$email', '$contact', '$personal_email', '$password', '$degree')";

        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['message'] = "Student created successfilly!!";
            header("location: student_add.php");
            exit(0);
        }
        else{
            $_SESSION['message'] = "Failed to create student";
            header("location: student_add.php");
            exit(0);
        }
    }
?>