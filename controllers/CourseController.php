<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\User;
use app\model\Course;
use app\model\CourseSubTopic;
use app\model\CourseTopic;
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
        $topics = CourseTopic::getCourseTopics($courseCode);
        if(empty($topics) and $_SESSION['user-role'] == 'Lecturer'){
            return $this->render(
                view: '/course/course_initialization',
                allowedRoles: ['Lecturer'],
                params: $params
            );
        } else {
            return $this->render(
                view: '/course/course_page',
                allowedRoles: ['Lecturer', 'Student'],
                params: $params
            );
        }
    }

    public function updateProgressBar(Request $request){

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

    public function courseInitialization(Request $request)
    {
        $lec_reg_no = unserialize($_SESSION['user'])->getRegNo();
        $body = $_POST;
        $topicsArray = $body['topics'];
        $subTopicsArray = $body['subtopic'];

        for ($i = 0; $i<count($topicsArray); $i++) {
            $checkboxes[$i] = $body['checkbox_'.$i] == 'on';
        }

        $courseCode = $_POST['course_code'];

        $courseSubTopics = new CourseSubTopic();
        $courseTopics = new CourseTopic();

        $courseTopics->insertCourseTopics($courseCode, $topicsArray);
        $courseSubTopics->insertCourseSubTopics($courseCode, $lec_reg_no, $topicsArray, $subTopicsArray, $checkboxes);


        $params['course'] = Course::getCourse($courseCode);
        return $this->render(
            view: 'course/course_page',
            allowedRoles: ['Lecturer'],
            params:$params
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