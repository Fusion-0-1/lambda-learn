<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class ProfileController extends Controller
{
    public function displayProfile()
    {
        $profile = unserialize($_SESSION['user']);
        return $this->render('profile', $profile->flatten());
    }
}