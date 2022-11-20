<?php

use app\core\Application;
use \app\controllers\SiteController;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');
$app->router->post('/profile', [SiteController::class, 'profile']);
$app->router->get('/update_profile', [SiteController::class, 'update_profile']);

$app->router->get('/login', [SiteController::class, 'login']);
$app->router->post('/login', [SiteController::class, 'login']);


$app->run();