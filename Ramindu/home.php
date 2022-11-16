<?php
session_start();
include('db.php');
include('navbar.php');
?>
<link href="css/main.css" rel="stylesheet">
</head>
<body>
<div class="main-container outer border flex flex-column v-center h-center">
    <h1>
        Welcome <?php echo $_SESSION['f_name'] . " " . $_SESSION['l_name']; ?> !
    </h1>
    <div class="flex flex-row v-center h-center">
        <h2>Registration Number: </h2>
        <h2><?php echo $_SESSION['reg_no']; ?></h2>
    </div>
    <div class="flex flex-row v-center h-center">
        <h2>Email: </h2>
        <h2><?php echo $_SESSION['email']; ?></h2>
    </div>
    <div class="flex flex-row v-center h-center">
        <h2>Contact No: </h2>
        <h2><?php echo $_SESSION['contact_no']; ?></h2>
    </div>
</div>
</body>
