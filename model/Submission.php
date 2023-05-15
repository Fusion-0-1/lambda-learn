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
    // stu
    private string $regNo;
    private string $submittedDate;
    private string $attachment;

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

    public static function createStuNewSubmission($courseCode, $topic, $description, $dueDate, $regNo, $allocatedMark=0, $allocatedPoint=0, $visibility=false, $location="",$submissionId="") {
        $stuSubmission = self::createNewSubmission($courseCode, $topic, $description, $dueDate, $allocatedMark, $allocatedPoint, $visibility, $location,$submissionId);
        $stuSubmission->regNo = $regNo;
        $stuSubmission->submittedDate = self::getSubmittedDate_($stuSubmission->regNo, $stuSubmission->courseCode, $stuSubmission->submissionId);
        $stuSubmission->attachment = self::getAttachment_($stuSubmission->regNo, $stuSubmission->courseCode, $stuSubmission->submissionId);
        return $stuSubmission;
    }

    public static function getSubmittedDate_($stu_reg_no, $course_code, $submission_id)
    {
        $result = Application::$db->select(
            table: 'StuCourseSubmission',
            where: ['stu_reg_no' => $stu_reg_no, 'course_code' => $course_code, 'submission_id' => $submission_id],
            limit: 1
        );
        $sub = Application::$db->fetch($result);
        return $sub['submitted_date'] ?? '';
    }

    public static function getAttachment_($stu_reg_no, $course_code, $submission_id)
    {
        $result = Application::$db->select(
            table: 'StuCourseSubmission',
            where: ['stu_reg_no' => $stu_reg_no, 'course_code' => $course_code, 'submission_id' => $submission_id],
            limit: 1
        );
        $sub = Application::$db->fetch($result);
        return $sub['stu_attachments'] ?? '';
    }

    public function isSubmitted()
    {
        return $this->attachment != '';
    }

    public static function getStuSubmission($regNo, $course_code, $submission_id): Submission
    {
        $result = Application::$db->select(
            table: 'coursesubmission',
            where: ['course_code' => $course_code, 'submission_id' => $submission_id],
            limit: 1
        );
        $sub = Application::$db->fetch($result);
        return self::createStuNewSubmission(
            courseCode: $sub['course_code'],
            topic: $sub['topic'],
            description: $sub['description'],
            dueDate: $sub['due_date'],
            regNo: $regNo,
            allocatedMark: $sub['allocated_mark'],
            allocatedPoint: $sub['allocated_point'],
            visibility: $sub['visibility'],
            location: $sub['attachments']?? '',
            submissionId: $sub['submission_id']
        );
    }


    public static function getSubmissions($course_code): array
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

    public function getFileNameFromPath()
    {
        $path = explode('/',$this->attachment);
        return $path[count($path)-1];
    }

    public function getAttachmentPath()
    {
        return explode("/public", $this->getAttachment_($this->regNo, $this->courseCode, $this->submissionId))[1];
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
        }
        return $files;
    }

    public function submissionInsert()
    {
        Application::$db->insert(
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

    public function stuSubmissionInsert()
    {
        if($this->checkExistsStuSubmission()){
            $this->stuSubmissionUpdate();
        } else {
            Application::$db->insert(
                table: 'StuCourseSubmission',
                values: [
                    'stu_reg_no' => $this->regNo,
                    'submission_id' => $this->submissionId,
                    'course_code' => $this->courseCode,
                    'submitted_date' => date('Y-m-d H:i:s'),
                    'stu_attachments' => $this->attachment
                ]
            );
        }
    }

    public function stuSubmissionUpdate()
    {
        Application::$db->update(
            table: 'StuCourseSubmission',
            columns: [
                'submitted_date' => date('Y-m-d H:i:s'),
                'stu_attachments' => $this->attachment
            ],
            where: ['stu_reg_no' => $this->regNo, 'submission_id' => $this->submissionId, 'course_code' => $this->courseCode]
        );
    }

    public function createStuSubmissionFolders($files)
    {
        $dir = 'User Uploads/Submissions/' . str_replace("/", " ", $this->courseCode) . '/' . $this->submissionId .'/'. 'Student_Attachments/' . $this->regNo;
        if (!file_exists($dir)) {
            mkdir($dir, recursive: true);
        }
//        var_dump($files);
//        for ($i = 0; $i < count($files['name']); $i++) {
            $fileName = $files['name'];
            $tmpName = $files['tmp_name'];
            $savedPath = $dir.'/'.$fileName;
            $fileExists = file_exists($savedPath);

            if ($fileExists) {
                unlink($savedPath);
            }
            move_uploaded_file($tmpName, $savedPath);
//        }
        $this->setAttachment(getcwd() . $savedPath);
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
        return $lastInsertId['submission_id'] ?? 0;
    }

    public function checkExistsStuSubmission(): bool
    {
        return Application::$db->checkExists(
            table: 'StuCourseSubmission',
            primaryKey: ['stu_reg_no' => $this->regNo, 'course_code' => $this->courseCode, 'submission_id' => $this->submissionId]
        );
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

    public static function deleteAllSubmissions($courseCode)
    {
        self::deleteLecAttachmentFolders();
        Application::$db->delete(
            table: 'CourseSubmission',
            where: ['course_code'=>$courseCode]
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

    public static function stuSubExists($regNo, $courseCode, $submissionId): bool
    {
        return Application::$db->checkExists(
            table: 'stucoursesubmission',
            primaryKey: ['stu_reg_no'=> $regNo,'course_code'=>$courseCode,'submission_id'=>$submissionId]
        );
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

    /*
    * @description Delete all the student submission folders
    */
    private static function deleteLecAttachmentFolders()
    {
        if (is_dir(getcwd(). "/User Uploads/Submissions/")) {
            //pwd - lambda-learn/public
            $submissions = scandir(getcwd() . "/User Uploads/Submissions/");
            // rmdir - User Uploads/Submissions/<course_code>/<sub_id>/Lecturer_Attachments
            foreach ($submissions as $submission) {
                if (!in_array($submission, ['.', '..'])) {
                    $submissionFolders = scandir(getcwd() . "/User Uploads/Submissions/$submission");
                    foreach ($submissionFolders as $submissionFolder) {
                        if (!in_array($submissionFolder, ['.', '..'])) {
                            $stuSubmissionFolder = getcwd() . "/User Uploads/Submissions/$submission/$submissionFolder/Lecturer_Attachments";
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
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @param string $attachment
     */
    public function setAttachment(string $attachment): void
    {
        $this->attachment = $attachment;
    }


    /**
     * @return string
     */
    public function getSubmittedDate(): string
    {
        return $this->submittedDate;
    }

    /**
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->attachment;
    }

}