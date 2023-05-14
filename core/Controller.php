<?php

namespace app\core;

/**
 * @package app\core
*/
class Controller
{
    /**
     * @description Render view with layout
     * @param $view
     * @param $allowedRoles
     * @param $params
     * @return array|false|string|string[]
     */
    public function render($view, $allowedRoles = [], $params = [])
    {
        if (self::isAuthorised($allowedRoles)) {
            return Application::$app->router->renderView($view, $params);
        } else {
            return Application::$app->router->renderView('error_404');
        }
    }

    /**
     * @description Render view without layout
     * @param $view
     * @param $allowedRoles
     * @param $params
     * @return array|false|string|string[]
     */
    public function renderOnlyView($view, $allowedRoles = [], $params = [])
    {
        if (self::isAuthorised($allowedRoles)) {
            return Application::$app->router->renderOnlyView($view, $params);
        } else {
            return Application::$app->router->renderView('error_404');
        }
    }

    /**
     * @description Check if user is authorised
     * @param $allowedRoles
     * @return bool
     */
    private function isAuthorised($allowedRoles = []) : bool
    {
        if (isset($_SESSION['user-role'])) {
            return in_array($_SESSION['user-role'], $allowedRoles) or $allowedRoles == [];
        }
        return true;
    }
}