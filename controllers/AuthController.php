<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isGet()) {
            return $this->renderOnlyView('login'); //TODO: Create login view from scratch(without layout)
        } else if ($request->isPost()) {
            $body = $request->getBody();
            var_dump($body);
        }
    }
}