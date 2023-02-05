<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\Course;

class CourseController extends Controller
{
    public function displayCourses()
    {
        $user = unserialize($_SESSION['user']);
        $userRegNo = $user->getRegNo();
        $courses = ['courses'=>Course::getUserCourses($userRegNo)];
        return $this->render('course/course_overview', $courses);
    }

    public function courseCreation()
    {
        return $this->render('course/course_creation', component: 'modal');
    }
}