<?php

use app\core\Application;
use \app\controllers\SiteController;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');
//$app->router->get('/profile', [SiteController::class, 'profile']);
$app->router->post('/profile', [SiteController::class, 'profile']);
$app->router->get('/update_profile', [SiteController::class, 'update_profile']);
//$app->router->post('/update_profile', [SiteController::class, 'profile']);

$app->run();