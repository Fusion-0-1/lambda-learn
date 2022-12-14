<?php session_start(); ?>
<?php require_once('connect/connection.php'); ?>

<?php 
    if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
}
?>
<?php 
	$errors = array();
	if (isset($_POST['submit'])) {
		$req_fields = array('heading', 'lec_name', 'content');
		foreach ($req_fields as $field) {
			if (empty(trim($_POST[$field]))) {
				$errors[] = $field . ' is required';
			}
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
</head>
<body>
        <header>
        <div class="appname">Lamda</div>
        <div class="loggedin">Wellcome <?php echo $_SESSION['user_name']; ?>! <a href="logout.php">Log Out</a></div>
        </header>


    <div class="main_card">
        <div class="course_name">Data Structures and Algorithms - Announcement</div>
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
            <div class="announcement_card">
                <form action="add-user.php" method="post" class="userform">
                <div class="container">
                    <textarea name="heading" placeholder="Add Announcement Heading..." class="add_headline" id="" wrap="hard"></textarea>
                    <button type="submit" class="btn" name="submit">Publish</button>
                </div>
                <div class="announcement_card_inside">
                    <div class="container_heading">
                        <div><input type="text" name="name" placeholder="Enter Your Name... " class="add_name"></div>
                        <div class="date_time">Date & Time</div>
                    </div>
                    <div  class="add_announcement_content_div">
                        <textarea id="ann_content" placeholder="Add Announcement content...   "></textarea>
                    </div>                   
                </div>
                </form>
            </div>

<script>
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }
    // const text_area = document.getElementById("ann_content");
    // text_area.addEventListener("keyup", e =>{   
    //     text_area.style.height="auto";
    //     let scHeight = e.target.scrollHeight; 
    //     text_area.style.height = '${scHeight}px';
    // });
        // const content = document.getElementById("ann_content");
        // content.style.cssText = 'height: ${content.scrollHeight}px; overflow-y: hidden';

        // content.addEventListener("input", function(){
        //     this.style.height = "auto";
        //     this.style.height = '${this.scrollHeight}px';
        // });
        
</script>

<?php

	$query = "SELECT heading, content, dates, lec_name FROM courseannouncement";
	$users = mysqli_query($connection, $query);

	if ($users) {
		while ($courseannouncement = mysqli_fetch_assoc($users)) {
?>
            <div class="announcement_card">
                <div class="container container_edit_delete" >
                    <div class="heading_content"><?php echo $courseannouncement['heading'] ?></div>
                    <div class="edit_delete_timeremaining">
                        <button class="delete_btn"><img src="./image/Delete.png" alt="delete Button"></button>
                        <button class="edit_btn"><img src="./image/Edit.png" alt="Edit Button"></button>                        
                    </div>
                </div>
                <div class="announcement_card_inside">
                    <div class="container_heading">
                        <div class="view_lecture_name"><?php echo $courseannouncement['lec_name'] ?></div>
                        <div class="date_time"><?php echo $courseannouncement['dates'] ?></div>
                    </div>
                    <div class="announcement_content">
                        <?php echo $courseannouncement['content'] ?>
                    </div>
                </div>
            </div>
<?php
		}
	} else {
		echo "Database query failed.";
	}
?>




        <!-- <div class="ann-card">
            <div class="container">
                <?php echo $courseannouncement['heading'] ?>
            </div>
            <div class="ann-card-inside">
                <div class="container_heading">
                    <div class="left"><?php echo $courseannouncement['lec_name'] ?></div>
                    <div class="right"><?php echo $courseannouncement['dates'] ?></div>
                </div>
                <p><?php echo $courseannouncement['content'] ?></p>    
            </div>
        </div> -->
<!-- </div> -->
    </div>
</body>
</html>
