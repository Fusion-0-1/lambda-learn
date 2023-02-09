<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\User;
use app\model\User\Admin;
use app\model\User\Lecturer;
use app\model\User\Student;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isGet()) {
            return $this->renderOnlyView('login');
        } else if ($request->isPost()) {
            $body = $request->getBody();
            $regNo = $body['reg_no'];
            $user = null;
            if(User::getUserType($regNo)) {
                if (User::authenticateUser($regNo, $body['password'])) {
                    if (User::getUserType($regNo) == 'Student') {
                        $user = Student::fetchStuFromDb($regNo);
                        $_SESSION['user-role'] = 'Student';
                    } else if (User::getUserType($regNo) == 'Lecturer') {
                        $user = Lecturer::fetchLecFromDb($regNo);
                        if (!$user->isCoordinator()){
                            $_SESSION['user-role'] = 'Lecturer';
                        } else {
                            $_SESSION['user-role'] = 'Coordinator';
                        }
                    } else if (User::getUserType($regNo) == 'Admin') {
                        $user = Admin::fetchAdminFromDb($regNo);
                        $_SESSION['user-role'] = 'Admin';
                    }
                    $user->setLogin();
                    $_SESSION['user'] = serialize($user);
                    $_SESSION['last_activity'] = time();
                    return $this->render('dashboard');
                }
            }
            return $this->renderOnlyView('login', ['error' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $user->setLogout();
            session_destroy();
        }
        return $this->renderOnlyView('login');
    }
}
