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
        $userRegno = $user->getRegNo();
        $course = Course::fetchCourseFromDb($userRegno);
        return $this->render('course_overview', ['course' => $course]);
    }
}