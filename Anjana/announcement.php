<?php session_start(); ?>
<?php require_once('connect/connection.php'); ?>
<?php include('navbar.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

date_default_timezone_set("Asia/Kolkata");

$errors = array();
$heading = '';
$lec_name = '';
$content = '';
$dates = '';
$annsid = '';
$msg = '';


//user form

if (isset($_GET['updated'])) {
    $ann_id = $_POST['anc_id_'];
    $heading = $_POST['heading'];
    $lec_name = $_POST['lec_name'];
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');

    $req_fields = array('heading', 'lec_name', 'content');
    foreach ($req_fields as $field) {
        if (empty(trim($_POST[$field]))) {
            $errors[] = $field . ' is required';
        }
    }

    $max_len_fields = array('heading' => 500, 'lec_name' => 100, 'content' => 5000);
    foreach ($max_len_fields as $field => $max_len) {
        if (strlen(trim($_POST[$field])) > $max_len) {
            $errors[] = $field . ' must be less than ' . $max_len . ' characters';
        }
    }

    if (empty($errors)) {
        // no errors found... adding new record
        $heading = mysqli_real_escape_string($connection, $_POST['heading']);
        $lec_name = mysqli_real_escape_string($connection, $_POST['lec_name']);
        $content = mysqli_real_escape_string($connection, $_POST['content']);
        $qy = "UPDATE courseannouncement SET ";
        $qy .= "heading = '{$heading}',";
        $qy .= "lec_name = '{$lec_name}',";
        $qy .= "content = '{$content}',";
        $qy .= "dates = '{$date}'";
        $qy .= " WHERE announcement_id ={$ann_id} LIMIT 1";


        $reslt = mysqli_query($connection, $qy);
        if ($reslt) {
            // query successful... redirecting to announcement page
            header('Location: announcement.php?announcement_update=true');
        } else {
            $errors[] = 'Failed to update the new record.';
        }
    }
}


// insert form
if (isset($_POST['submit'])) {
    // $heading = $_POST['heading'];
    // $lec_name = $_POST['lec_name'];
    // $content = $_POST['content'];

    $req_fields = array('heading', 'lec_name', 'content');
    foreach ($req_fields as $field) {
        if (empty(trim($_POST[$field]))) {
            $errors[] = $field . ' is required';
        }
    }

    $max_len_fields = array('heading' => 500, 'lec_name' => 100, 'content' => 5000);
    foreach ($max_len_fields as $field => $max_len) {
        if (strlen(trim($_POST[$field])) > $max_len) {
            $errors[] = $field . ' must be less than ' . $max_len . ' characters';
        }
    }

    if (empty($errors)) {
        // no errors found... adding new record
        $heading = mysqli_real_escape_string($connection, $_POST['heading']);
        $lec_name = mysqli_real_escape_string($connection, $_POST['lec_name']);
        $content = mysqli_real_escape_string($connection, $_POST['content']);

        $query = "INSERT INTO courseannouncement ( ";
        $query .= "heading, lec_name, content";
        $query .= ") VALUES (";
        $query .= "'{$heading}', '{$lec_name}', '{$content}'";
        $query .= ")";

        $result = mysqli_query($connection, $query);
        if ($result) {
            // query successful... redirecting to announcement page
            header('Location: announcement.php?user_added=true');
        } else {
            $errors[] = 'Failed to add the new record.';
        }
    }
}

//delete data
if (isset($_GET["delete_ann_id"])) {
    $an_id = mysqli_real_escape_string($connection, $_GET['delete_ann_id']);
    $q = "DELETE FROM courseannouncement WHERE announcement_id = '$an_id'";
    $resultset = mysqli_query($connection, $q);
    if ($resultset) {
        header('Location: announcement.php?msg=query_successfully');
    } else {
        header('Location: announcement.php?err=query_failed');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="./css/announcement.css">
    <link rel="stylesheet" href="./css/topbar.css">
</head>

<body>
    <header class="head">
        <div class="header_logo"><img src="./image/logo.png" alt=""></div>
        <div class="topbar_logout"><p> Welcome ! <a href="logout.php"><img src="/image/logout.png" alt="logout image"></a></p></div>
    </header>


    <div class="main_card">
        <div class="course_name">Announcement</div>
        <div class="bl" id="blur">
            <?php
            if (!empty($msg)) {
                echo '<div class="msg">';
                echo 'Insert Successfully';
                echo '</div>';
            }
            ?>
            <div class="announcement_card">
                <form action="announcement.php" method="post" class="userform">
                    <div class="display_required">
                        <?php
                        if (!empty($errors)) {
                            echo '<div class="errmsg">';
                            echo '<b>There were error(s) on your form.</b><br>';
                            foreach ($errors as $error) {
                                echo '- ' . $error . '<br>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="container">
                        <textarea name="heading" placeholder="Add Announcement Heading..." class="add_headline" id="" wrap="hard" <?php echo 'value="' . $heading . '"'; ?>></textarea>
                        <button type="submit" class="btn" name="submit">Publish</button>
                    </div>
                    <div class="announcement_card_inside">
                        <div class="container_heading">
                            <div><input type="text" name="lec_name" placeholder="Enter Your Name... " class="add_name" <?php echo 'value="' . $lec_name . '"'; ?>></div>
                            <div class="date_time"></div>
                        </div>
                        <div class="add_announcement_content_div">
                            <textarea id="ann_content" name="content" placeholder="Add Announcement content...   " <?php echo 'value="' . nl2br($content) . '"'; ?>></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            $query = "SELECT announcement_id, heading, content, dates, lec_name FROM courseannouncement ORDER BY announcement_id DESC ";
            $users = mysqli_query($connection, $query);
            if ($users) {
                while ($courseannouncement = mysqli_fetch_assoc($users)) {
            ?>

                    <div class="announcement_card">
                        <div class="container container_edit_delete">
                            <div class="heading_content"><?php echo $courseannouncement['heading'] ?></div>
                            <div class="edit_delete_timeremaining">
                                <a href="announcement.php?delete_ann_id=<?php echo $courseannouncement['announcement_id'] ?>" class="delete_btn" onclick="return confirm('Are you sure?');"><img src="./image/Delete.png" alt="Delete Button"></a>
                                <a href="announcement.php?announcement_id=<?php echo $courseannouncement['announcement_id'] ?>" class="edit_btn"><img src="./image/Edit.png" alt="Edit Button"></a>
                            </div>
                        </div>
                        <div class="announcement_card_inside">
                            <div class="container_heading">
                                <div class="view_lecture_name"><?php echo $courseannouncement['lec_name'] ?></div>
                                <div class="date_time"><?php echo $courseannouncement['dates'] ?></div>
                            </div>
                            <div class="announcement_content">
                                <?php echo nl2br($courseannouncement['content']) ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "Database query failed.";
            }
            ?>
        </div>
    </div>


    <div id="popup">
        <div class="announcement_card pop_announcement">
            <form action="announcement.php?updated=true" method="post" class="userform">
                <div class="container">
                    <textarea name="heading" id="update_ann_heading" placeholder="Add Announcement Heading..." class="add_headline" id="" wrap="hard"></textarea>
                    <button type="submit" class="btn" name="click">Submit</button>
                </div>
                <div class="announcement_card_inside">
                    <div class="container_heading">
                        <div><input id="update_lec_name" type="text" name="lec_name" placeholder="Enter Your Name... " class="add_name"></div>
                        <div class="date_time" id="update_ann_date"></div>
                    </div>
                    <div class="add_announcement_content_div">
                        <textarea id="update_ann_content" name="content" placeholder="Add Announcement content...   "></textarea>
                    </div>
                    <div><input id="updated_anc_id" type="text" name="anc_id_" class="add_name" hidden></div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function tooglepopup(id, heading, content, lec_name, dates) {
            const background = document.getElementById('blur');
            background.classList.toggle('active');
            const popup = document.getElementById('popup');
            popup.classList.toggle('active');

            document.getElementById('updated_anc_id').value = id;
            document.getElementById('update_ann_content').value = content;
            document.getElementById('update_lec_name').value = lec_name;
            document.getElementById('update_ann_heading').value = heading;
            document.getElementById('update_ann_date').value = dates;
        }
    </script>
    <?php
    if (isset($_GET["announcement_id"])) {
        $ann_id = mysqli_real_escape_string($connection, $_GET['announcement_id']);
        $qry = "SELECT * FROM courseannouncement WHERE announcement_id = '{$ann_id}' LIMIT 1";
        $resultset = mysqli_query($connection, $qry);
            if ($resultset) {
                if (mysqli_num_rows($resultset) == 1) {
                    $results = mysqli_fetch_assoc($resultset);
                    $heading = $results['heading'];
                    $content = $results['content'];
                    $lec_name = $results['lec_name'];
                    $dates = $results['dates'];
                    echo "<script type='text/javascript'>tooglepopup('$ann_id', '$heading', '" . mysqli_real_escape_string($connection, $content) . "', '$lec_name', '$dates');</script>";
                } else {
                    header('Location: announcement.php?err=user_not_found');
                }
            } else {
                header('Location: announcement.php?err=query_failed');
            }
        }
    ?>
</body>

</html>