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
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/form.css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <title>Lambda - Learn</title>
</head>
<body>
<div class="sidebar flex v-center h-center">
    <div class="elements">
        <a href="/"><i class="fa fa-home" aria-hidden="true"></i></a>
    </div>
</div>
<div class="topbar flex h-justify v-center font">
    <div class="elements">
        <img src="/images/logo.png" alt="logo" class="logo">
    </div>

    <div class="v-center flex">
        <div class="flex elements">
            <div class="flex">
                <input type="search" class="search-bar input" placeholder="Search" >
            </div>
            <div class="flex v-center">
                <span><button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button></span>
            </div>
        </div>
        <div class="elements">
            <span class="point-border point">
                <span class="text-bold">1204</span>
                <span class="text-normal">Points</span>
            </span>
            <span class="point-border rank text-bold">
                5
            </span>
        </div>

        <div class="elements">
                <a href="/profile">Inuri Lavanya</a>
        </div>

        <div class="elements h-center">
            <img src="/images/profile.png" alt="profile" class="profile-nav">
        </div>

        <div class="elements">
            <a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </div>
    </div>
</div>


<div class="container">
    {{content}}
</div>
</body>
</html>