<?php

namespace app\model;

use app\core\Application;

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


    private function __construct() {}

    public static function createNewSubmission($courseCode, $topic, $description, $allocatedMark, $allocatedPoint, $dueDate, $visibility, $location="",$submissionId="") {
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
                allocatedMark: $sub['allocated_mark'],
                allocatedPoint: $sub['allocated_point'],
                dueDate: $sub['due_date'],
                visibility: $sub['visibility'],
                location: $sub['attachments']?? '',
                submissionId: $sub['submission_id']
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


}