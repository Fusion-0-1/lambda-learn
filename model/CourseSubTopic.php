<?php

namespace app\model;

use app\core\Application;

class CourseSubTopic {
    private string $courseCode;
    private string $topicId;
    private string $subTopicId;
    private string $subTopicName;
    private int $isBeingTracked;
    private int $isCovered;
//    stuCompleted 1 / 0

    public function __construct() {}

    public static function createNewSubTopic($subTopicId, $subTopicName, $isBeingTracked, $isCovered) {
        $subTopic = new CourseSubTopic();
        $subTopic->subTopicId = $subTopicId;
        $subTopic->subTopicName = $subTopicName;
        $subTopic->isBeingTracked = $isBeingTracked;
        $subTopic->isCovered = $isCovered;
// stuComplete, pass default 0 in the param
        return $subTopic;
    }

    public static function getCourseSubTopics($topicId, $courseCode): array {
        $subTopics = [];
        $results = Application::$db->select(
            table: 'CourseSubTopic',
            columns: ['sub_topic_id', 'sub_topic', 'is_being_tracked', 'is_covered'],
            where: ['course_code' => $courseCode, 'topic_id' => $topicId],
        );
        // fetch stuCourseSubTopic to array A
        while ($subTopic = Application::$db->fetch($results)){
            $subTopics[] = self::createNewSubTopic(
                $subTopic['sub_topic_id'],
                $subTopic['sub_topic'],
                $subTopic['is_being_tracked'],
                $subTopic['is_covered']
                // stuCompleted: find subtopic id matching to this from A
                // stuCompleted: function() {
            // body
                // }
            );
        }

        return $subTopics;
    }

    public function insertCourseSubTopics($courseCode,$lec_reg_no, $topicsArray, $subTopicsArray, $chekboxes)
    {
        $topicId = 1;
        foreach ($topicsArray as $index => $topic) {
            $subTopicId = 1;
            foreach ($subTopicsArray[$index] as $subTopic) {
                if($subTopic != ''){
                    $subTopicIdFormatted = $topicId . '.' . sprintf('%02d', $subTopicId);
                    Application::$db->insert(
                        table: 'CourseSubTopic',
                        values: [
                            'course_code' => $courseCode,
                            'topic_id' => $topicId,
                            'sub_topic_id' => $subTopicIdFormatted,
                            'sub_topic' => $subTopic,
                            'is_being_tracked' =>(int)$chekboxes[$topicId-1],
                            'lec_reg_no' => $lec_reg_no
                        ]
                    );
                }
                $subTopicId++;
            }
            $topicId++;
        }
    }

    public function updateProgress($courseCode,$subTopicId, $user, $regNo)
    {
            Application::$db->update(
                table: 'CourseSubTopic',
                columns: ['is_covered' => 1],
                where: ['course_code' => $courseCode, 'sub_topic_id' => $subTopicId]
            );
    }



    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return string
     */
    public function getTopicId(): string
    {
        return $this->topicId;
    }

    /**
     * @param string $topicId
     */
    public function setTopicId(string $topicId): void
    {
        $this->topicId = $topicId;
    }

    /**
     * @return string
     */
    public function getSubTopicId(): string
    {
        return $this->subTopicId;
    }

    /**
     * @param string $subTopicId
     */
    public function setSubTopicId(string $subTopicId): void
    {
        $this->subTopicId = $subTopicId;
    }

    /**
     * @return string
     */
    public function getSubTopicName(): string
    {
        return $this->subTopicName;
    }

    /**
     * @param string $subTopicName
     */
    public function setSubTopicName(string $subTopicName): void
    {
        $this->subTopicName = $subTopicName;
    }

    /**
     * @return int
     */
    public function getIsBeingTracked(): int
    {
        return $this->isBeingTracked;
    }

    /**
     * @param int $isBeingTracked
     */
    public function setIsBeingTracked(int $isBeingTracked): void
    {
        $this->isBeingTracked = $isBeingTracked;
    }

    /**
     * @return int
     */
    public function getIsCovered(): int
    {
        return $this->isCovered;
    }

    /**
     * @param int $isCovered
     */
    public function setIsCovered(int $isCovered): void
    {
        $this->isCovered = $isCovered;
    }
}
