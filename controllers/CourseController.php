<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\User;
use app\model\Course;
use app\model\CourseSubTopic;
use app\model\CourseTopic;
use app\model\Submission;
use DateTime;
use DateTimeZone;

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
        $params['submissions'] = Submission::getSubmission($params['course_code']);
        return $this->render(
            view: '/submissions',
            allowedRoles: ['Lecturer'],
            params:  $params
        );
    }

    public function CreateSubmission(Request $request)
    {
        $body = $request->getBody();
        $dueDateStr = $body['duetime'];
        $dueDate = new DateTime($dueDateStr);
        $visibility = filter_var($body['visibility'], FILTER_VALIDATE_BOOLEAN);

        $course_submissions = Submission::createNewSubmission(
            courseCode: $body['course_code'],
            topic: $body['heading'],
            description: $body['content'],
            allocatedMark: $body['mark'],
            allocatedPoint: $body['point'],
            dueDate: $dueDate->format('Y-m-d H:i:s'),
            visibility: $visibility,
        );

        $submission_id = $course_submissions->getLastSubmissionId()+1;
        $files = $_FILES['attachment'];
        $numFiles = count($files['name']);
        // create course and submission folders if they don't exist
        $course_dir = 'User Uploads/Submissions/' . $body['course_code'];
        if (!file_exists($course_dir)) {
            mkdir($course_dir);
        }
        $sub_dir = $course_dir . '/' . $submission_id;
        if (!file_exists($sub_dir)) {
            mkdir($sub_dir);
        }
        $LecturerAttachments = $course_dir . '/' . $submission_id .'/'. 'Lecturer_Attachments';
        if (!file_exists($LecturerAttachments)) {
            mkdir($LecturerAttachments);
        }

        for ($i = 0; $i < $numFiles; $i++) {
            $fileName = $files['name'][$i];
            $tmpName = $files['tmp_name'][$i];
            $fileExists = file_exists($LecturerAttachments.'/'.$fileName);

            if ($fileExists) {
                echo "Sorry, file already exists.";
            } else {
                move_uploaded_file($tmpName, $LecturerAttachments.'/'.$fileName);
            }
        }
        $course_submissions->setLocation('C:/xampp/htdocs/lambda-learn/public/User Uploads/Submissions/'.$body['course_code'].'/'.$submission_id.'/' . 'Lecturer_Attachments');
        $course_submissions->submissionsInsert();
        header("Location: /submissions?course_code=".$body['course_code']);
    }

    public function SubmissionVisibility(Request $request)
    {
        $body = $request->getBody();
        Submission::visibilityUpdate($body['course_code'],$body['submission_id'],$body['visibility']);
        header("Location: /submissions?course_code=".$body['course_code']);
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