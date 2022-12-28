<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class CourseController extends Controller
{
    public function displayCourses()
    {
        $course_overview = unserialize($_SESSION['user']);
        return $this->render('course_overview', $course);
    }
}