<?php
session_start();
include('db.php');
include('header.html');
?>
    <link href="css/login.css" rel="stylesheet">
    <title>Lambda LMS</title>
    </head>

    <body>
    <section class="login">
        <div class="login_container flex flex-row h-center">
            <div class="background_image_container">
                <img src="images/login/login_cover.jpg" alt="Lambda Logo"/>
            </div>
            <div class="login_container_form flex flex-column v-center h-center main-container border">
                <div class="login_container_logo">
                    <img src="images/lambda%20learn.png" alt="logo">
                </div>
                <?php
                if (isset($_GET['error'])) {
                    echo "<p class='error error-bg text-center'> Invalid Credentials </p>";
                }
                ?>
                <form action="login_validation.php" method="POST" class="login_form flex flex-column h-center">
                    <label class="margin-top">
                        <input id="reg_no" class="input" type="text" name="reg_no" placeholder="Registration Number" required/>
                    </label>
                    <label class="margin-top">
                        <input id="password" class="input" type="password" name="password" placeholder="Password" required/>
                    </label>
                    <button class="dark-btn margin-top" type="submit" name="login">Login</button>
                </form>
            </div>
        </div>
    </section>
    </body>
    </html>

<?php
include('footer.html');
?>