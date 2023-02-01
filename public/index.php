<?php

use app\controllers\AnnouncementController;
use app\controllers\AuthController;
use app\controllers\ProfileController;
use app\core\Application;
use app\controllers\CourseController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'port' => $_ENV['DB_PORT'],
    ]
];

$app = new Application(dirname(__DIR__), $config);


// Public routes
// -------------------------------------------------------------------------
$app->router->get('/', 'dashboard');
$app->router->get('/calender', 'calender');

$app->router->get('/course_overview', [CourseController::class, 'displayCourses']);

$app->router->get('/submissions', 'submissions');

$app->router->get('/account_creation', 'account_creation');
$app->router->get('/leaderboard', 'leaderboard');
$app->router->post('/upload_student_csv', [ProfileController::class, 'uploadCSV']);

$app->router->get('/course_initialization', 'course_initialization');

$app->router->get('/site_announcement', [AnnouncementController::class, 'displaySiteAnnouncements']);

$app->router->get('/profile', [ProfileController::class, 'displayProfile']);
$app->router->post('/profile', [ProfileController::class, 'editProfile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);
// -------------------------------------------------------------------------

// Admin routes
// -------------------------------------------------------------------------
$app->router->get('/account_creation', 'account_creation');
$app->router->post('/upload_student_csv', [ProfileController::class, 'uploadCSV']);
// -------------------------------------------------------------------------


$app->run();
