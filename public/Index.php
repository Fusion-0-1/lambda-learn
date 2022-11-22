<?php

use app\controllers\AuthController;
use app\core\Application;
use \app\controllers\SiteController;

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

$app->router->get('/', 'home');
$app->router->post('/profile', [SiteController::class, 'profile']);
$app->router->get('/update_profile', [SiteController::class, 'update_profile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);


$app->run();
