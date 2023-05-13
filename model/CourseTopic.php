<?php

namespace app\model;

use app\core\Application;

/**
 *
 */
class CourseTopic {
    private string $courseCode;
    private string $topicId;
    private string $topicName;
    private array $subTopics = [];
    private int $isBeingTracked;

    public function __construct() {}
    public static function createNewTopic($topicId, $topicName, $subTopics = []): CourseTopic
    {
        $topic = new CourseTopic();
        $topic->topicId = $topicId;
        $topic->topicName = $topicName;
        $topic->subTopics = $subTopics;

        return $topic;
    }

    /**
     * @description Insert course topics to the database
     * @param $courseCode
     * @param $topicsArray
     * @return void
     */
    public function insertCourseTopics($courseCode, $topicsArray)
    {
        $topicId = 1;
        foreach ($topicsArray as $topic) {
            if($topic != ''){
                Application::$db->insert(
                    table: 'CourseTopic',
                    values: [
                        'course_code' => $courseCode,
                        'topic_id' => $topicId,
                        'topic' => $topic
                    ]
                );
                $topicId++;
            } else {
                break;
            }
        }
    }

    /**
     * @description Get course topics from the database together with its sub topics
     * @param $courseCode
     * @return array
     */
    public static function getCourseTopics($courseCode): array
    {
        $topics = [];
        $results = Application::$db->select(
            table: 'CourseTopic',
            columns: ['topic_id', 'topic', 'course_code'],
            where: ['course_code' => $courseCode],
        );
        while ($topic = Application::$db->fetch($results)){
            $courseSubTopics = CourseSubTopic::getCourseSubTopics($topic['topic_id'], $topic['course_code']);
            $topics[] = self::createNewTopic(
                topicId: $topic['topic_id'],
                topicName: $topic['topic'],
                subTopics: $courseSubTopics
            );
        }

        return $topics;
    }

    /**
     * @description Edit course topics
     * @param $courseCode
     * @param $topicId
     * @param $topicName
     * @return bool
     */
    public static function editTopics($courseCode, $topicId, $topicName) : bool
    {
        Application::$db->update(
            table: 'CourseTopic',
            columns: ['topic' => $topicName],
            where: ['course_code' => $courseCode, 'topic_id' => $topicId]
        );
        return true;
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @description Get completion percentage of sub topics for a lecturer
     * @return int
     */
    public function getLecSubTopicCompletePercentage(): int
    {
        return ($this->getLecSubTopicCompleteCount() / sizeof($this->subTopics)) * 100;
    }

    /**
     * @description Get completed sub topic count
     * @param bool $stu
     * @return int
     */
    private function getSubTopicCompleteCount(bool $stu): int
    {
        return count(array_filter($this->subTopics, function ($subTopic) use ($stu) {
            return ($stu ? $subTopic->getStuIsCompleted() : $subTopic->getIsCovered()) and $subTopic->getIsBeingTracked();
        }));
    }

    /**
     * @description Get completed sub topic count for a student
     * @return int
     */
    public function getStuSubTopicCompleteCount(): int
    {
        return $this->getSubTopicCompleteCount(stu: true);
    }

    /**
     * @description Get completed sub topic count for a lecturer
     * @return int
     */
    public function getLecSubTopicCompleteCount(): int
    {
        return $this->getSubTopicCompleteCount(stu: false);
    }


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
    public function getTopicName(): string
    {
        return $this->topicName;
    }

    /**
     * @param string $topicName
     */
    public function setTopicName(string $topicName): void
    {
        $this->topicName = $topicName;
    }

    /**
     * @return array
     */
    public function getSubTopics(): array
    {
        return $this->subTopics;
    }

    /**
     * @param array $subTopics
     */
    public function setSubTopics(array $subTopics): void
    {
        $this->subTopics = $subTopics;
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
}
