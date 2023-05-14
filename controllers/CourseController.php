<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\CSVFile;
use app\core\Request;
use app\core\User;
use app\model\Course;
use app\model\CourseAnnouncement;
use app\model\CourseSubTopic;
use app\model\CourseTopic;
use app\model\Submission;
use app\model\User\Lecturer;
use app\model\User\Student;
use DateTime;
use DateTimeZone;

class CourseController extends Controller
{
    /**
     * @description Display all courses in the overview page
     * @return array|false|string|string[]
     */
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

    /**
     * @description Display course page
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function displayCourse(Request $request)
    {
        $body = $request->getBody();
        $courseCode = $body['course_code'];
        $params['course'] = Course::getCourse($courseCode);
        $topics = CourseTopic::getCourseTopics($courseCode);

        $today = new DateTime();
        $isSemesterEnd = ($today > new DateTime(Application::$admin_config->getSemEndDate())
            and $today < new DateTime(Application::$admin_config->getSemStartDate()));
        $params['isSemesterEnd'] = $isSemesterEnd;

        if(empty($topics) and $_SESSION['user-role'] == 'Lecturer'){
            return $this->render(
                view: '/course/course_initialization',
                allowedRoles: ['Lecturer'],
                params: $params
            );
        } else {
            $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($courseCode);
            return $this->render(
                view: '/course/course_page',
                allowedRoles: ['Lecturer', 'Student'],
                params: $params
            );
        }
    }

    /**
     * @description Update course page
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function updateCoursePage(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $regNo = $user->getregNo();

        $today = new DateTime();
        $isSemesterEnd = ($today > new DateTime(Application::$admin_config->getSemEndDate())
            and $today < new DateTime(Application::$admin_config->getSemStartDate()));
        $params['isSemesterEnd'] = $isSemesterEnd;

        if(isset($body['update_progress_bar'])){
            $courseCode = $body['course_code'];
            $subTopicId = $body['course_subtopic'];
            $topicId = $body['course_topic'];

            $params['mssg'] = CourseSubTopic::updateProgress($courseCode, $topicId, $subTopicId);
            $params['course'] = Course::getCourse($courseCode);
            $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($courseCode);

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

    public function resetCoursePage(Request $request)
    {
        $body = $request->getBody();
        $courseCode = $body['course_code'];
        Student::removeStudentsFromCourse($courseCode);
        Course::removeCourseAnnouncements($courseCode);
        CourseSubTopic::removeSlidesAndRecordings($courseCode);
        Submission::deleteAllSubmissions($courseCode);
        Course::removeCourseSubToicsAndTopics($courseCode);

        $params['mssg_reset'] = "Course reset successfully";

        $params['course'] = Course::getCourse($courseCode);
        $topics = CourseTopic::getCourseTopics($courseCode);

        $today = new DateTime();
        $isSemesterEnd = ($today > new DateTime(Application::$admin_config->getSemEndDate())
            and $today < new DateTime(Application::$admin_config->getSemStartDate()));
        $params['isSemesterEnd'] = $isSemesterEnd;

        if(empty($topics) and $_SESSION['user-role'] == 'Lecturer'){
            return $this->render(
                view: '/course/course_initialization',
                allowedRoles: ['Lecturer'],
                params: $params
            );
        }
        $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($courseCode);
        return $this->render(
            view: '/course/course_page',
            allowedRoles: ['Lecturer', 'Student'],
            params: $params
        );
    }

    /**
     * @description Display all submissions for a course
     * @param Request $request
     * @return array|false|string|string[]
     */
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

    /**
     * @description Create a course submission
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function CreateSubmission(Request $request)
    {
        $body = $request->getBody();
        $dueDateStr = $body['duetime'];
        $dueDate = new DateTime($dueDateStr);
        $course_submissions = Submission::createNewSubmission(
            courseCode: $body['course_code'],
            topic: $body['heading'],
            description: $body['content'],
            dueDate: $dueDate->format('Y-m-d H:i:s'),
            allocatedMark: (int)$body['mark'] ?? 0,
            allocatedPoint: (int)$body['point'] ?? 0,
            visibility: $body['visibility'] ?? false,
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
        $course_submissions->setLocation(getcwd() . '/User Uploads/Submissions/'.$body['course_code'].'/'.$submission_id.'/' . 'Lecturer_Attachments');
        $course_submissions->submissionInsert();
        header("Location: /submissions?course_code=".$body['course_code']);
    }

    /**
     * @description Update submission visibility
     * @param Request $request
     * @return void
     */
    public function changeSubmissionVisibility(Request $request)
    {
        $body = $request->getBody();
        Submission::updateVisibility($body['course_code'],$body['submission_id'],$body['visibility']);
        header("Location: /submissions?course_code=".$body['course_code']);
    }

    /**
     * @description Update all submissions
     * @param Request $request
     * @return void
     */
    public function updateAllSubmissions(Request $request)
    {
        $body = $request->getBody();
        $files = $_FILES['edit_attachment'];
        $numFiles = count($files['name']);
        $folderPath = $body['upload_attachment_edit'];

        // Check for new files
        $newFilesUploaded = false;
        foreach ($files['name'] as $name) {
            if (!empty($name)) {
                $newFilesUploaded = true;
                break;
            }
        }

        if ($newFilesUploaded) {
            // Remove old files
            $oldFiles = glob($folderPath . "/*");
            foreach ($oldFiles as $file) {
                unlink($file);
            }

            // Move new files
            for ($i = 0; $i < $numFiles; $i++) {
                $fileName = $files['name'][$i];
                $tmpName = $files['tmp_name'][$i];

                if (!empty($fileName)) {
                    move_uploaded_file($tmpName, $folderPath . '/' . $fileName);
                }
            }
        }

        Submission::updateSubmission($body['course_code'],$body['submission_id_edit'],$body['edit_heading'],$body['edit_mark'],$body['edit_duetime'],$body['edit_content']);
        header("Location: /submissions?course_code=".$body['course_code']);
    }

    /**
     * @description Delete a submission
     * @param Request $request
     * @return void
     */
    public function deleteCourseSubmission(Request $request)
    {
        $body = $request->getBody();
        Submission::deleteCourseSubmission($body['course_code'],$body['submission_id_delete']);
        header("Location: /submissions?course_code=".$body['course_code']);
    }

    /**
     * @description Display course marks upload page
     * @return array|false|string|string[]
     */
    public function displayCourseMarkUpload(Request $request)
    {
        $body = $request->getBody();
        $params['course'] = Course::getCourse($body['course_code']);
        return $this->render(
            view: '/marks_upload',
            allowedRoles: ['Lecturer', 'Coordinator'],
            params: $params
        );
    }

    public function updateCourseMarks(Request $request)
    {
        $body = $request->getBody();
        $courseCode = $body['course_code'];
        $params['course'] = Course::getCourse($body['course_code']);

        $file = new CSVFile($request->getFile());
        $marks_dir = 'User Uploads/Exam marks/' . $body['course_code'];
        if (!file_exists($marks_dir)) {
            mkdir($marks_dir);
        }
        $categorizedData = $file->readCSV(
            uploadExamMarks: true
        );

        $path = 'User Uploads/Exam marks/'.$courseCode;
        $params['invalid_user'] = false;
        for($i=0; $i<sizeof($categorizedData['reg_no']); $i++){
            if((!User::userExists($categorizedData['reg_no'][$i])) || (Student::checkStudentAssignedToCourse($categorizedData['reg_no'][$i], $courseCode))){
                $params['invalid_user'] = true;
            }
        }
        if(!$params['invalid_user']){
            for($i=0; $i<sizeof($categorizedData['reg_no']); $i++){
                Course::updateExamMarks($categorizedData['reg_no'][$i], $courseCode, $categorizedData['exam_mark'][$i], $path);
            }
            $file_path = $marks_dir . '/' . date('Y') . '.csv';
            if(file_exists($file_path)){
                unlink($file_path);
            }
            $file->saveFileOnServer($path = $marks_dir . '/' . date('Y') . '.csv');
        }
        return $this->render(
            view: '/marks_upload',
            allowedRoles: ['Lecturer', 'Coordinator'],
            params: $params
        );
    }

    /**
     * @description Display course creation page
     * @return array|false|string|string[]
     */
    public function displayCourseCreation()
    {
        $user = unserialize($_SESSION['user'])->getRegNo();

        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;

        $params['courses'] = [];
        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], $params['degree_program'])) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Create a new course
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function createNewCourse(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user'])->getRegNo();
        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;

        $courseCode = $body['course_code'];
        $courseName = $body['course_name'];
        if($body['course_type'] == 'Optional'){
            $isOptional = 1;
        } else {
            $isOptional = 0;
        }

        if((str_starts_with($courseCode, $params['degree_program'])) and
            (str_starts_with(explode(" ", $courseCode)[1], (string)$year))){
            $params['course_insert'] = Course::insertCourse($courseCode, $courseName, $isOptional, $user);
        } else {
            $params['invalid_course'] = true;
        }

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], $params['degree_program'])) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Edit a course
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function editCourse(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user'])->getRegNo();

        $params['course_update'] = Course::UpdateCourse($body['course_code'], $body['course_name']);

        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], $params['degree_program'])) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Delete a course
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function deleteCourse(Request $request)
    {
        $body = $request->getBody();
        $params['course_delete'] = Course::deleteCourse($body['course_code']);
        $user = unserialize($_SESSION['user'])->getRegNo();

        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], $params['degree_program'])) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: 'course/course_creation',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Display assign users to courses page
     * @return array|false|string|string[]
     */
    public function displayAssignUsersToCourses()
    {
        $user = unserialize($_SESSION['user'])->getRegNo();
        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;
        $params['lecturers'] = Lecturer::fetchLecturers();

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], $params['degree_program'])) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Update assign users to courses page
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function updateAssignUsersToCourses(Request $request)
    {
        $body = $request->getBody();
        $courseCode = trim(explode("-", $body['course'])[0]);

        if(isset($body['assign_lecturer'])){
            if(isset($body['assign'])){
                $lecturer = $body['lecturer'];
                $params['exists'] = Lecturer::assignLecturersToCourse($lecturer, $courseCode);
            }
            elseif(isset($body['delete'])) {
                $lecturer = $body['lecturer'];
                $params['is_deleted'] = Lecturer::removeLecturersFromCourse($lecturer, $courseCode);
            }
        } else {
            $regNoLike = $body['batch_year'] . '/' . $body['degree_program'];
            $params['exists'] = Student::assignStudentsToCourse($regNoLike, $courseCode);
        }

        $user = unserialize($_SESSION['user'])->getRegNo();
        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;
        $params['lecturers'] = Lecturer::fetchLecturers();

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], 'CS')) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }

    /**
     * @description Upload assign users to courses page CSV file
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function uploadAssignUsersToCourses(Request $request)
    {
        $file = new CSVFile($request->getFile());
        $categorizedData = $file->readCSV(
            assignStudents: true
        );
        if($categorizedData){
            $params['invalid_course'] = $categorizedData['invalid_course'];
            $params['invalid_reg_no'] = $categorizedData['invalid'];
            $params['exists'] = $categorizedData['exist'];
        }

        $user = unserialize($_SESSION['user'])->getRegNo();
        $degreeProgramCode = Lecturer::fetchLecFromDb($user)->getDegreeProgramCode();
        $params['degree_program'] = explode(" ", $degreeProgramCode)[0];
        $params['year_of_coordinating'] = explode(" ", $degreeProgramCode)[1];
        $year = date('Y') - $params['year_of_coordinating'] - 1;
        $params['lecturers'] = Lecturer::fetchLecturers();

        foreach (Course::fetchAllCourses() as $course){
            if((str_starts_with($course['course_code'], 'CS')) and
                (str_starts_with(explode(" ", $course['course_code'])[1], (string)$year))){
                $params['courses'][] = $course;
            }
        }
        return $this->render(
            view: '/assign_users_to_courses',
            allowedRoles: ['Coordinator'],
            params: $params
        );
    }


    /**
     * @description Display course edits
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function displayCourseEdit(Request $request)
    {
        $body = $request->getBody();
        $params['course'] = Course::getCourse($body['course_code']);
        $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($body['course_code']);

        return $this->render(
            view: '/course/course_edit',
            allowedRoles: ['Lecturer'],
            params: $params
        );
    }

    /**
     * @description Edit course topics and sub topics
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function editCourseTopicsAndSubTopics(Request $request)
    {
        $body = $request->getBody();
        $courseCode = $body['course_code'];
        $topics = CourseTopic::getCourseTopics($courseCode);

        $updatedTopics = $body['update_topics'];
        $updatedSubtopics = $body['update_subtopics'];
        $topicCount = 0;
        foreach ($topics as $topic){
            $subTopicCount = 0;
            if($topic->getTopicName() != $updatedTopics[$topicCount]){
                $topicId = $topicCount+1;
                $params['is_topic_edited'] = CourseTopic::editTopics($courseCode, $topicId, $updatedTopics[$topicCount]);
            }
            foreach ($topic->getSubTopics() as $subTopic){
                if($subTopic->getSubTopicName() != $updatedSubtopics[$topicCount+1][$subTopicCount]){
                    $subTopicId = ($topicCount+1) . '.' . sprintf('%02d', ($subTopicCount+1));
                    $params['is_sub_topic_edited'] = CourseSubTopic::editSubTopics($courseCode, ($topicCount+1),
                        $subTopicId, $updatedSubtopics[$topicCount+1][$subTopicCount]);
                }
                $subTopicCount++;
            }
            $topicCount++;
        }

        $today = new DateTime();
        $isSemesterEnd = ($today > new DateTime(Application::$admin_config->getSemEndDate())
            and $today < new DateTime(Application::$admin_config->getSemStartDate()));
        $params['isSemesterEnd'] = $isSemesterEnd;

        $params['course'] = Course::getCourse($courseCode);
        $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($courseCode);
        return $this->render(
            view: '/course/course_page',
            allowedRoles: ['Lecturer'],
            params: $params
        );
    }

    /**
     * @description Add new course topics and sub topics
     * @param Request $request
     * @return array|false|string|string[]
     */
    public function addNewCourseTopicsAndSubTopics(Request $request)
    {
        $body = $request->getBody();
        $newTopics = $body['topics'];
        $newSubTopics = $body['subtopic'];

        $courseCode = $body['course_code'];
        $user = unserialize($_SESSION['user']);
        $lecRegNo = $user->getregNo();
        $params['add_topics'] = Course::addNewTopicsAndSubTopics($courseCode, $newTopics, $newSubTopics, $lecRegNo);

        $params['course'] = Course::getCourse($courseCode);
        $params['courseAnnouncements'] = CourseAnnouncement::getCourseAnnouncements($courseCode);

        $today = new DateTime();
        $isSemesterEnd = ($today > new DateTime(Application::$admin_config->getSemEndDate())
            and $today < new DateTime(Application::$admin_config->getSemStartDate()));
        $params['isSemesterEnd'] = $isSemesterEnd;

        return $this->render(
            view: '/course/course_page',
            allowedRoles: ['Lecturer'],
            params: $params
        );
    }

    public function uploadRecording(Request $request) {
        $body = $request->getBody();
        $records = $_FILES['recattachment'];
        $numRecords = count($records['name']);

        for ($i = 0; $i < $numRecords; $i++) { // error msg display
            if ($records['error'][$i] !== UPLOAD_ERR_OK) {
                // Handle upload error
                // For example, you could redirect the user back to the upload page with an error message
                header("Location: /lecturer_upload_recording?error=upload_failed");
                exit;
            }
        }
        // create course and submission folders if they don't exist
        $course_dir = 'User Uploads/lecturerUploads/' . $body['rec_course_code'];
        if (!file_exists($course_dir)) {
            mkdir($course_dir, recursive: true);;
        }
        $topic_dir = $course_dir . '/' . $body['rec_course_topic'];
        if (!file_exists($topic_dir)) {
            mkdir($topic_dir, recursive: true);
        }
        $subtopic_dir = $topic_dir . '/' . $body['rec_course_subtopic'];
        if (!file_exists($subtopic_dir)) {
            mkdir($subtopic_dir, recursive: true);
        }

        for ($i = 0; $i < $numRecords; $i++) {
            $fileName = $records['name'][$i];
            $tmpName = $records['tmp_name'][$i];
            $fileType = $records['type'][$i];

            $allowedTypes = ['video/mp4', 'video/mpeg', 'video/ogg', 'video/webm'];
            if (!in_array($fileType, $allowedTypes)) {
                // handle invalid file type error here
                die('Invalid file type'); // error msg display
            }
            if (!move_uploaded_file($tmpName, $subtopic_dir.'/'.$fileName)) {
                echo 'file upload failed';  // error msg display
                return;
            }
        }
        if (!CourseSubTopic::lecturerRecordingExits($body['rec_course_code'], $body['rec_course_topic'], $body['rec_course_subtopic'], getcwd().'/User Uploads/lecturerUploads/' . $body['rec_course_code'] . '/' . $body['rec_course_topic'] . '/' . $body['rec_course_subtopic'])) {
            CourseSubTopic::insertLecturerRecording($body['rec_course_code'], $body['rec_course_topic'], $body['rec_course_subtopic'], getcwd().'/User Uploads/lecturerUploads/' . $body['rec_course_code'] . '/' . $body['rec_course_topic'] . '/' . $body['rec_course_subtopic']);
        }
        header("Location: course_page?course_code=" . $body['rec_course_code']);
    }
}