<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
} else {
    // Session timeout after 30 minutes
    if (time() - $_SESSION['last_activity'] > 60*30) {
        $user = unserialize($_SESSION['user']);
        $user->setLogout();
        session_destroy();
        header('Location: /logout');
        exit;
    }
    $_SESSION['last_activity'] = time();
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
    <link rel="stylesheet" href="css/404.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon-light.svg">

    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <title>Lambda - Learn </title>
</head>

<body>
    
    <div class="main-container-404 flex-wrap flex flex-row h-center border inner">
        <div class="secondary-container-img">
            <img src="images/404.png" alt="404_error">
        </div>
        <div class="secondary-container flex flex-column v-center h-center">
            <div class="heading-color">
                <h1>PAGE NOT FOUND!</h1>
                <br>
                <h2 class="text-normal">The page you are looking for seems to be missing...</h2>
                <br>
                <h3><a href="">Back</a></h3>
            </div>
    </div>

</body>
</html>
