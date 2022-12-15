<?php 

session_start(); 

require_once $_SERVER["DOCUMENT_ROOT"]."/Dilanga/connect.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    // function validate($data){

    //    $data = trim($data);

    //    $data = stripslashes($data);

    //    $data = htmlspecialchars($data);

    //    return $data;

    // }

    // $username = validate($_POST['username']);

    // $password = validate($_POST['password']);

    if (empty($username)) {

        header("Location: index.php?error=User Name is required");

        exit();

    }else if(empty($password)){

        header("Location: index.php?error=Password is required");

        exit();

    }else{

        $sql = "SELECT * FROM Student WHERE reg_no='$username' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['reg_no'] === $username && $row['password'] === $password) {

                echo "Logged in!";

                $_SESSION['reg_no'] = $row['reg_no'];

                header("Location: dashboard.php");

                exit();

            }else{

                header("Location: index.php?error=Incorect User name or password");

                exit();

            }

        }else{

            header("Location: index.php?error=Incorect User name or password");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}

?>