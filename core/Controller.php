<?php

namespace app\core;

/**
 * @package app\core
*/
class Controller
{
    public function render($view, $params = [])
    {
        return Application::$app->router->render_view($view, $params);
    }
}