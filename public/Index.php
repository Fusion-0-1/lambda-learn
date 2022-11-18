<?php

use app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app->router->get('/', function() {
    return 'Hello World';
});
$app->router->get('/test', function() {
    return 'test';
});

$app->run();