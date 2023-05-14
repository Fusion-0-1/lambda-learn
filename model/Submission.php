<?php

namespace app\model;

use app\core\Application;
use app\core\User;

class Submission
{
    private int $submissionId;
    private string $courseCode;
    private string $topic;
    private string $description;
    private int $allocatedMark;
    private int $allocatedPoint;
    private string $dueDate;
    private bool $visibility;
    private string $location;
    private string $regNo;
    private string $submittedDate;


    private function __construct() {}

    public static function createNewSubmission($courseCode, $topic, $description, $dueDate, $allocatedMark=0, $allocatedPoint=0, $visibility=false, $location="",$submissionId="") {
        $submission = new Submission();
        if ($submissionId != ""){
            $submission->submissionId = $submissionId;
        }
        $submission->courseCode = $courseCode;
        $submission->topic = $topic;
        $submission->description = $description;
        $submission->allocatedMark = $allocatedMark;
        $submission->allocatedPoint = $allocatedPoint;
        $submission->dueDate = $dueDate;
        $submission->visibility = $visibility;
        $submission->location = $location;
        return $submission;
    }

    public static function createStuNewSubmission($courseCode,$regNo, $submissionId, $submittedDate='', $location='') {
        $stuSubmission = new Submission();
        if ($submissionId != ""){
            $stuSubmission->submissionId = $submissionId;
        }
        $stuSubmission->courseCode = $courseCode;
        $stuSubmission->submittedDate = $submittedDate ;
        $stuSubmission->regNo = $regNo;
        $stuSubmission->location = $location;
        return $stuSubmission;
    }

    public static function getSubmission($course_code): array
    {
        $assignmentSubmissions = [];
        $results = Application::$db->select(
            table: 'coursesubmission',
            where: ['course_code' => $course_code],
            order: 'submission_id DESC'
        );
        while ($sub = Application::$db->fetch($results)){
            $assignmentSubmissions[] = self::createNewSubmission(
                courseCode: $sub['course_code'],
                topic: $sub['topic'],
                description: $sub['description'],
                dueDate: $sub['due_date'],
                allocatedMark: $sub['allocated_mark'],
                allocatedPoint: $sub['allocated_point'],
                visibility: $sub['visibility'],
                location: $sub['attachments']?? '',
                submissionId: $sub['submission_id']
            );
        }
        return $assignmentSubmissions;
    }

    public static function getStuSubmission($courseCode,$regNo): array
    {
        $assignmentSubmissions = [];
        $results = Application::$db->select(
            table: 'stucoursesubmission',
            where: ['course_code' => $courseCode,'stu_reg_no'=>$regNo]
        );
        while ($subStu = Application::$db->fetch($results)){
            $assignmentSubmissions[] = self::createStuNewSubmission(
                courseCode: $subStu['course_code'],
                regNo: $subStu['stu_reg_no'],
                submissionId: $subStu['submission_id'],
                submittedDate: $subStu['submitted_date'],
                location: $subStu['stu_attachments']?? ''
            );
        }
        return $assignmentSubmissions;
    }
    public function getAttachmentFileNames($path) {
        $files = [];
        if (is_dir($path)) {
            $dir = scandir($path);
            foreach ($dir as $file) {
                if (!in_array($file, ['.', '..'])) {
                    $files[] = $file;
                }
            }
        }return $files;
    }

    public function submissionInsert()
    {
        $db = Application::$db->insert(
            table: 'coursesubmission',
            values: [
                'course_code' => $this->courseCode,
                'topic' => $this->topic,
                'description' => $this->description,
                'allocated_mark' => $this->allocatedMark,
                'allocated_point' => $this->allocatedPoint,
                'visibility' => $this->visibility,
                'due_date' => $this->dueDate,
                'attachments' => $this->location
            ]
        );
    }

    public function stuSubmissionExists()
    {
        return Application::$db->checkExists(
            table: 'stucoursesubmission',
            primaryKey: ['stu_reg_no'=>$this->regNo,'course_code'=>$this->courseCode,'submission_id'=>$this->submissionId]
        );
    }

    public function stuSubmissionInsert()
    {
        $stuAttachmentExists = [];
        if ($this->stuSubmissionExists()) {
            $stuAttachmentExists[] = $this->location;
        } else {
            Application::$db->insert(
                table: 'stucoursesubmission',
                values: [
                    'stu_reg_no' => $this->regNo,
                    'course_code' => $this->courseCode,
                    'submission_id' => $this->submissionId,
                    'submitted_date' => $this->submittedDate ?: date('Y-m-d H:i:s'),
                    'stu_attachments' => $this->location
                ]
            );
        }
        return $stuAttachmentExists;
    }

    public static function stuSubExists($regNo, $courseCode, $submissionId): bool
    {
        return Application::$db->checkExists(
            table: 'stucoursesubmission',
            primaryKey: ['stu_reg_no'=> $regNo,'course_code'=>$courseCode,'submission_id'=>$submissionId]
        );
    }

    public function getLastSubmissionId(){
        $result = Application::$db->select(
            table: 'coursesubmission',
            columns:['submission_id'],
            where: ['course_code' => $this->courseCode],
            order: 'submission_id DESC',
            limit: 1
        );
        $lastInsertId = Application::$db->fetch($result);
        return $lastInsertId['submission_id'];
    }

    public static function updateVisibility($courseCode,$submissionId,$visibility)
    {
        Application::$db->update(
            table: 'coursesubmission',
            columns: ['visibility'=>$visibility,],
            where: ['submission_id'=>$submissionId,'course_code'=>$courseCode]
        );
    }

    public static function updateSubmission($courseCode,$submissionId,$topic,$allocatedMark,$dueDate,$description)
    {
        Application::$db->update(
            table: 'coursesubmission',
            columns: ['topic'=>$topic,'allocated_mark'=>$allocatedMark,'due_date'=> $dueDate, 'description'=>$description],
            where: ['course_code'=>$courseCode,'submission_id'=>$submissionId]
        );
    }

    public static function deleteCourseSubmission($courseCode,$submissionId)
    {
        Application::$db->delete(
            table: 'coursesubmission',
            where: ['course_code' => $courseCode,'submission_id'=>$submissionId]
        );
    }

    /**
     * @description Get all the submissions of a given student
     * @param User $user
     * @return array
     */
    public static function getUserSubmissions(User $user): array
    {
        $assignmentSubmissions = [];
        $results = Application::$db->select(
            table: 'CourseSubmission CS',
            columns: ['CS.course_code', 'CS.topic', 'CS.description', 'CS.due_date', 'CS.submission_id'],
            join: [
                [
                    'table' => 'StuCourse SC',
                    'on' => 'CS.course_code = SC.course_code'
                ]
            ],
            where: ['CS.visibility' => 1, 'SC.stu_reg_no' => $user->getRegNo()],
        );
        while ($submission = Application::$db->fetch($results)) {
            $assignmentSubmissions[] = self::createNewSubmission(
                courseCode: $submission['course_code'],
                topic: $submission['topic'],
                description: $submission['description'],
                dueDate: $submission['due_date'],
                submissionId: $submission['submission_id']
            );
        }
        return $assignmentSubmissions;
    }

    /*
     * @description Delete all the student submissions of a given course
     */
    public static function truncateStuCourseSubmissioms()
    {
        self::deleteStuSubmissionFolders();
        Application::$db->truncateTable('StuCourseSubmission');
    }

    /*
     * @description Delete all the student submission folders
     */
    private static function deleteStuSubmissionFolders()
    {
        if (is_dir(getcwd(). "/User Uploads/Submissions/")) {
            //pwd - lambda-learn/public
            $submissions = scandir(getcwd() . "/User Uploads/Submissions/");
            // rmdir - User Uploads/Submissions/<course_code>/<sub_id>/Student_Submissions
            foreach ($submissions as $submission) {
                if (!in_array($submission, ['.', '..'])) {
                    $submissionFolders = scandir(getcwd() . "/User Uploads/Submissions/$submission");
                    foreach ($submissionFolders as $submissionFolder) {
                        if (!in_array($submissionFolder, ['.', '..'])) {
                            $stuSubmissionFolder = getcwd() . "/User Uploads/Submissions/$submission/$submissionFolder/Student_Submissions";
                            if (is_dir($stuSubmissionFolder))
                                rmdir($stuSubmissionFolder);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getSubmissionId(): int
    {
        return $this->submissionId;
    }

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getAllocatedMark(): int
    {
        return $this->allocatedMark;
    }

    /**
     * @return int
     */
    public function getAllocatedPoint(): int
    {
        return $this->allocatedPoint;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return bool
     */
    public function getVisibility(): bool
    {
        return $this->visibility;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getRegNo(): string
    {
        return $this->regNo;
    }

    /**
     * @return string
     */
    public function getSubmittedDate(): string
    {
        return $this->submittedDate;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }
}