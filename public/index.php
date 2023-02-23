<?php

use app\controllers\AnnouncementController;
use app\controllers\AuthController;
use app\controllers\Kanbanboard;
use app\controllers\LeaderboardController;
use app\controllers\ProfileController;
use app\controllers\SummaryViewController;
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
$app->router->get('/cs2003', [CourseController::class, 'displayCourse']);
$app->router->get('/kanbanboard', [Kanbanboard::class, 'displayKanbanboard']);
$app->router->get('/attendance_upload', 'attendance_upload');
$app->router->get('/utilization', 'utilization');

$app->router->get('/submissions', [CourseController::class, 'displayAllSubmissions']);
$app->router->get('/marks_upload', [CourseController::class, 'displayCourseMarkUpload']);

$app->router->get('/leaderboard', [LeaderboardController::class, 'displayLeaderboard']);

$app->router->get('/course_creation', [CourseController::class, 'courseCreation']);
$app->router->get('/course_initialization', [CourseController::class, 'courseInitialization']);
$app->router->get('/attendance_course_progress', [SummaryViewController::class, 'displayCoordinatorCharts']);

$app->router->get('/site_announcement', [AnnouncementController::class, 'displaySiteAnnouncements']);

$app->router->get('/profile', [ProfileController::class, 'displayProfile']);
$app->router->post('/profile', [ProfileController::class, 'editProfile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);
// -------------------------------------------------------------------------

// Admin routes
// -------------------------------------------------------------------------
$app->router->get('/account_creation', [ProfileController::class, 'displayAccountCreation']);
$app->router->post('/upload_student_csv', [ProfileController::class, 'uploadCSV']);
// -------------------------------------------------------------------------

// Coordinator routes
// -------------------------------------------------------------------------
$app->router->get('/assign_users_to_courses', [CourseController::class, 'displayAssignUsersToCourses']);
// -------------------------------------------------------------------------

$app->router->post('/test', [AnnouncementController::class, 'createAnnouncements']);


$app->run();
