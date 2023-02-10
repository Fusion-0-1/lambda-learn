<?php

namespace app\core;

/**
 * @package app\core
*/
class Controller
{
    public function render($view, $allowedRoles = [], $params = [])
    {
        if (self::isAuthorised($allowedRoles)) {
            return Application::$app->router->renderView($view, $params);
        } else {
            return Application::$app->router->renderView('error_404');
        }
    }
    public function renderOnlyView($view, $allowedRoles = [], $params = [])
    {
        if (self::isAuthorised($allowedRoles)) {
            return Application::$app->router->renderOnlyView($view, $params);
        } else {
            return Application::$app->router->renderView('error_404');
        }
    }

    private function isAuthorised($allowedRoles = []) : bool
    {
        if (isset($_SESSION['user-role'])) {
            return in_array($_SESSION['user-role'], $allowedRoles) or $allowedRoles == [];
        }
        return true;
    }
}