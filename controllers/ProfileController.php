<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class ProfileController extends Controller
{
    public function displayProfile()
    {
        $profile = unserialize($_SESSION['user']);
        return $this->render('profile', ['user'=>$profile]);
    }

    public function editProfile(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $user->setContactNo($body['contact']);
        $user->setPersonalEmail($body['personal_email']);
        $user->editProfile();
        return $this->render('profile', ['user'=>$user]);
    }
}