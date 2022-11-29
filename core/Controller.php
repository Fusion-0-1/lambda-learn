<?php

namespace app\core;

/**
 * @package app\core
*/
class Controller
{
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
    public function renderOnlyView($view, $params = [])
    {
        return Application::$app->router->renderOnlyView($view, $params);
    }
}