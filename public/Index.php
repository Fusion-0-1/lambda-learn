<?php

use app\controllers\AuthController;
use app\controllers\ProfileController;
use app\core\Application;

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

$app->router->get('/', 'dashboard');

$app->router->get('/course_overview', 'course_overview');

$app->router->get('/profile', [ProfileController::class, 'displayProfile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();
