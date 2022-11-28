<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\User;
use app\model\Student;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isGet()) {
            return $this->renderOnlyView('login'); //TODO: Create login view from scratch(without layout)
        } else if ($request->isPost()) {
            $body = $request->getBody();
            $regNo = $body['reg_no'];
            $user = null;
            if(User::getUserType($regNo)) {
                if (User::authenticateUser($regNo, $body['password'])) {
                    if (User::getUserType($regNo) == 'Student') {
                        $user = new Student($regNo);
                    } else if (User::getUserType($regNo) == 'Lecturer') {
                        $user = new Lecturer($regNo);
                    } else if (User::getUserType($regNo) == 'Admin') {
                        $user = new Admin($regNo);
                    }
                    $_SESSION['user'] = $user;
                    return $this->render('home'); // TODO: Change to dashboard and create dashboard view
                }
            }
            // TODO: Accept this error message from the login view
            return $this->renderOnlyView('login', ['error' => 'Invalid credentials']);
        }
    }
}