<?php

use app\controllers\AnnouncementController;
use app\controllers\AuthController;
use app\controllers\KanbanboardController;
use app\controllers\LeaderboardController;
use app\controllers\ProfileController;
use app\controllers\ReportController;
use app\controllers\SummaryViewController;
use app\core\Application;
use app\controllers\CourseController;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
$admin_config = parse_ini_file("../admin_configuration.ini", true);
$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env');
$dotenv->load();
$config = [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'port' => $_ENV['DB_PORT'],
    ],
    'mailer' => [
        'host' => $_ENV['SMTP_HOST'],
        'port' => $_ENV['SMTP_PORT'],
        'username' => $_ENV['SMTP_USER'],
        'password' => $_ENV['SMTP_PASS'],
        'from' => $_ENV['SMTP_FROM'],
        'from_name' => $_ENV['SMTP_FROM_NAME'],
        'encryption' => $_ENV['SMTP_SECURE'],
    ]
];

$app = new Application(dirname(__DIR__), $config, $admin_config);


// Public routes
// -------------------------------------------------------------------------
$app->router->get('/', 'dashboard');
$app->router->get('/calender', [KanbanboardController::class, 'displayCalender']);

$app->router->get('/course_overview', [CourseController::class, 'displayCourses']);
$app->router->get('/course_page', [CourseController::class, 'displayCourse']);


$app->router->get('/kanbanboard', [KanbanboardController::class, 'displayKanbanboard']);
$app->router->post('/insert_task', [KanbanboardController::class, 'insertKanbanTasks']);
$app->router->post('/delete_task', [KanbanboardController::class, 'deleteKanbanTasks']);
$app->router->post('/update_task', [KanbanboardController::class, 'updateKanbanTasks']);
$app->router->post('/update_task_state', [KanbanboardController::class, 'updateKanbanTasksState']);

$app->router->post('/course_page', [CourseController::class, 'updateCoursePage']);
$app->router->post('/lecturer_upload_recording', [CourseController::class, 'uploadRecording']);

$app->router->get('/course_edit', [CourseController::class, 'displayCourseEdit']);
$app->router->post('/edit_topics', [CourseController::class, 'editCourseTopicsAndSubTopics']);
$app->router->post('/add_new_topics', [CourseController::class, 'addNewCourseTopicsAndSubTopics']);

$app->router->get('/attendance_upload', [ReportController::class, 'uploadAttendance']);
$app->router->post('/attendance_upload', [ReportController::class, 'uploadAttendance']);

$app->router->get('/utilization', [SummaryViewController::class, 'displayUtilizationReport']);

$app->router->get('/submissions', [CourseController::class, 'displayAllSubmissions']);
$app->router->post('/update_submissions', [CourseController::class, 'updateAllSubmissions']);
$app->router->post('/delete_course_submission', [CourseController::class, 'deleteCourseSubmission']);
$app->router->post('/submissions', [CourseController::class, 'CreateSubmission']);
$app->router->post('/submission_visibility', [CourseController::class, 'changeSubmissionVisibility']);

$app->router->get('/marks_upload', [CourseController::class, 'displayCourseMarkUpload']);
$app->router->post('/marks_upload', [CourseController::class, 'updateCourseMarks']);

$app->router->get('/leaderboard', [LeaderboardController::class, 'displayLeaderboard']);

$app->router->get('/course_creation', [CourseController::class, 'displayCourseCreation']);
$app->router->post('/create_course', [CourseController::class, 'createNewCourse']);
$app->router->post('/edit_course', [CourseController::class, 'editCourse']);
$app->router->post('/delete_course', [CourseController::class, 'deleteCourse']);

$app->router->get('/attendance_course_progress', [SummaryViewController::class, 'displayCoordinatorCharts']);

$app->router->get('/site_announcement', [AnnouncementController::class, 'displaySiteAnnouncements']);
$app->router->get('/course_announcement', [AnnouncementController::class, 'displayCourseAnnouncements']);

$app->router->post('/site_announcement', [AnnouncementController::class, 'createSiteAnnouncements']);
$app->router->post('/course_announcement', [AnnouncementController::class, 'createCourseAnnouncements']);

$app->router->post('/update_site_announcement', [AnnouncementController::class, 'updateSiteAnnouncements']);
$app->router->post('/update_course_announcement', [AnnouncementController::class, 'updateCourseAnnouncements']);

$app->router->post('/delete_site_announcement', [AnnouncementController::class, 'deleteSiteAnnouncements']);
$app->router->post('/delete_course_announcement', [AnnouncementController::class, 'deleteCourseAnnouncements']);


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
$app->router->post('/assign_users_to_courses', [CourseController::class, 'updateAssignUsersToCourses']);
$app->router->post('/upload_student_course_csv', [CourseController::class, 'uploadAssignUsersToCourses']);

// -------------------------------------------------------------------------



$app->run();
