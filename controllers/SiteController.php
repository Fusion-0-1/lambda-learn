<?php

namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class Response
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
//    public function profile()
//    {
//        $params = [
//            'fname' => "Ramindu",
//            'lname' => "Walgama"
//        ];
//        return $this->render('profile_page', $params);
//    }

    public function profile(Request $request)
    {
        $body = $request->getBody();
        echo "<pre>";
        var_dump($body);
        echo "</pre>";
        exit;
//        return $this->render('profile_page');
    }

    public function update_profile()
    {
        return $this->render('update_profile');
    }

    public function handle_form(Request $request) {
        $body = $request->getBody();

    }
}