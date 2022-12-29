<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class CourseController extends Controller
{
    public function displayCourses()
    {
        $user = unserialize($_SESSION['user']);
        $course = $user->getRegNo();
        return $this->render('course_overview', $course);
    }
}