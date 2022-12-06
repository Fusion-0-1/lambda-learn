<?php
if (isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Browser meta tags -->
    <meta charset="UTF-8" />
    <meta content="Lambda Learning Management System" name="description" />
    <meta
            content="Lambda, Learning Management System, LMS, Lambda Learning, University"
            name="keywords"
    />
    <meta content="Fusion 0-1" name="author">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Open Graph meta tags for social media sharing -->
    <meta content="Lambda - Fusion 0-1" property="og:title" />
    <meta
            content="Lambda Learning Management System"
            property="og:description"
    />


    <!-- Fonts -->
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/favicon-light.svg">

    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <title>Lambda - Learn </title>
</head>
<body>
    <div class="login login_container flex-wrap flex align-stretch h-center margin-top">
        <div class="background_image_container">
            <img src="images/login.png" alt="login">
        </div>
        <div class="login_container_form flex align-stretch flex-column v-center h-center main-container border">
            <div class="login_container_logo">
                <img src="images/logo.png" alt="logo">
            </div>
            <div class="heading-color">
                <h3 class="text-center text-normal">Institute of Fusion</h3>
                <h2 class="text-normal">Login</h2>
                <h1>Welcome</h1>
            </div>
            <div id="error" class="error-message">
            <?php if (isset($error)) echo $error; ?>
            </div>
                <form class="login_form flex align-stretch flex-column h-center" action="/login" name="form_login" onsubmit="return isValid()" method="POST">
                    <input type="text" name="reg_no" placeholder="Registration No" id="reg_no" class="input margin-top" required> <br>
                    <input type="password" name="password" placeholder="Password" id="password" class="input margin-top" required><br>
                    <a href="" class="float-right" id="forget_pass">Forgot password?</a><br><br>
                    <input type="submit" value="Login" name="login" id="btn" class="dark-btn margin-top">
                </form>
        </div>
    </div>

    <script>
        function isValid(){
            let reg_no = document.forms["form_login"]["reg_no"].value;
            try {
                let reg_no_split = reg_no.split("/");

                if(reg_no_split[0].length === 4
                    && !isNaN(reg_no_split[0])
                    && ((reg_no_split[1]).toLowerCase() === "cs" || (reg_no_split[1]).toLowerCase() === "is" ||
                        (reg_no_split[1]).toLowerCase() === "lc" || (reg_no_split[1]).toLowerCase() === "ad")
                    && (reg_no_split[2].length === 4 && !isNaN(reg_no_split[2]))
                ){
                    return true;
                } else {
                    throw 'Invalid Registration Number';
                }
            } catch (e) {
                document.getElementById("error").innerHTML=("Invalid Registration No");
                return false;
            }
        }
    </script>

</body>
</html>

