<?php

namespace app\controllers;


use app\core\Application;
use app\core\Controller;

/**
 * Class Response
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    public function profile(): string
    {
        $params = [
            'fname' => "Ramindu",
            'lname' => "Walgama"
        ];
        return $this->render('profile_page', $params);
    }

    public function update_profile(): string
    {
        return $this->render('update_profile');
    }
}