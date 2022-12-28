<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class CourseController extends Controller
{
    public function displayCourses()
    {
        return $this->render('course_overview', $course);
    }
}