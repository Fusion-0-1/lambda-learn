<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\User;
use app\model\Course;
use app\model\CourseSubTopic;
use app\model\CourseTopic;
use app\model\submission;
use app\model\User\Lecturer;
use app\model\User\Student;

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

    public function updateCoursePage(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $regNo = $user->getregNo();
        if(isset($body['update_progress_bar'])){
            $courseCode = $body['course_code'];
            $subTopicId = $body['course_subtopic'];
            $courseSubTopic = new CourseSubTopic();
            $courseSubTopic->updateProgress($courseCode,$subTopicId);

            $params['course'] = Course::getCourse($courseCode);

            return $this->render(
                view: '/course/course_page',
                allowedRoles: ['Lecturer', 'Student'],
                params: $params
            );
        } else {
            $topicsArray = $body['topics'];
            $subTopicsArray = $body['subtopic'];

            for ($i = 0; $i<count($topicsArray); $i++) {
                $checkboxes[$i] = $body['checkbox_'.$i] == 'on';
            }

            $courseCode = $_POST['course_code'];

            $courseSubTopics = new CourseSubTopic();
            $courseTopics = new CourseTopic();

            $courseTopics->insertCourseTopics($courseCode, $topicsArray);
            $courseSubTopics->insertCourseSubTopics($courseCode, $regNo, $topicsArray, $subTopicsArray, $checkboxes);


            $params['course'] = Course::getCourse($courseCode);
            return $this->render(
                view: 'course/course_page',
                allowedRoles: ['Lecturer'],
                params:$params
            );
        }
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

    public function courseCreation()
    {
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator']
        );
    }

    public function displayAssignUsersToCourses()
    {
        $users = Student::fetchStudents();

        $regNos = [];
        $degreePrograms = [];
        foreach ($users as $user) {
            $regNos[] = $user["reg_no"];
            $degreePrograms[] = $user['degree_program_code'];
        }

        $params['batch_years'] = Student::getBatchYears($regNos);
        $params['degree_programs'] = Student::getDegreePrograms($degreePrograms);
        $params['lecturers'] = Lecturer::fetchLecturers();
        $params['courses'] = Course::fetchAllCourses();;

        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    public function updateAssignUsersToCourses(Request $request)
    {
        $body = $request->getBody();
        $courseCode = trim(explode("-", $body['course'])[0]);

        if(isset($body['assign_lecturer'])){
            $lecturer = $body['lecturer'];
            Lecturer::assignLecturersToCourses($lecturer, $courseCode);
        } else {
            $regNo = $body['batch_year'] . '/' . $body['degree_program'];
            Student::assignStudentsToCourses($regNo, $courseCode);
        }
        $users = Student::fetchStudents();

        $regNos = [];
        $degreePrograms = [];
        foreach ($users as $user) {
            $regNos[] = $user["reg_no"];
            $degreePrograms[] = $user['degree_program_code'];
        }

        $params['batch_years'] = Student::getBatchYears($regNos);
        $params['degree_programs'] = Student::getDegreePrograms($degreePrograms);
        $params['lecturers'] = Lecturer::fetchLecturers();
        $params['courses'] = Course::fetchAllCourses();

        $params['mssg'] = true;
        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }
}