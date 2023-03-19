<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\Course;
use app\model\submission;

class CourseController extends Controller
{
    public function displayCourses()
    {
        $user = unserialize($_SESSION['user']);
        $courses = ['courses'=>Course::getUserCourses($user)];
        return $this->render(
            view: 'course/course_overview',
            allowedRoles: ['Lecturer', 'Student', 'Coordinator'],
            params: $courses
        );
    }

    public function displayCourse(Request $request)
    {
        $body = $request->getBody();
        $courseCode = $body['course_code'];
        $params['course'] = Course::getCourse($courseCode);
        return $this->render(
            view: '/course/course_page',
            allowedRoles: ['Lecturer', 'Student'],
            params: $params
        );
    }

    public function displayAllSubmissions(Request $request)
    {
        $body = $request->getBody();
        $params['course_code'] = $body['course_code'];
        $params['submissions'] = submission::getSubmission($params['course_code']);
        return $this->render(
            view: '/submissions',
            allowedRoles: ['Lecturer'],
            params:  $params
        );
    }

    public function displayCourseMarkUpload()
    {
        return $this->render(
            view: '/marks_upload',
            allowedRoles: ['Lecturer', 'Coordinator']
        );
    }

    public function courseInitialization()
    {
        return $this->render(
            view: 'course/course_initialization',
            allowedRoles: ['Lecturer']
        );
    }
    public function courseCreation()
    {
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator']
        );
    }

    public function displayAssignUsersToCourses()
    {
        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator']
        );
    }
}