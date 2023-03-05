<?php

namespace app\model;

use app\core\Application;

class submission
{
    private int $submissionId;
    private string $courseCode;
    private string $topic;
    private string $description;
    private int $allocatedMark;
    private int $allocatedPoint;
    private string $dueDate;
    private string $visibility;

    private function __construct() {}

    public static function createNewSubmission($courseCode, $topic, $description, $allocatedMark, $allocatedPoint, $dueDate, $visibility, $submissionId=null) {
        $submission = new submission();
        if ($submissionId != null){
            $submission->submissionId = $submissionId;
        }
        $submission->courseCode = $courseCode;
        $submission->topic = $topic;
        $submission->description = $description;
        $submission->allocatedMark = $allocatedMark;
        $submission->allocatedPoint = $allocatedPoint;
        $submission->dueDate = $dueDate;
        $submission->visibility = $visibility;

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
                $sub['course_code'],
                $sub['topic'],
                $sub['description'],
                $sub['allocated_mark'],
                $sub['allocated_point'],
                $sub['due_date'],
                $sub['visibility'],
                (int)$sub['submission_id'],
            );

        }
        return $assignmentSubmissions;
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
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }


}