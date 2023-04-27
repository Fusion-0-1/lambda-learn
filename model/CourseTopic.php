<?php

namespace app\model;

use app\core\Application;

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

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return int
     */
    public function getLecSubTopicCompletePercentage(): int
    {
        return ($this->getLecSubTopicCompleteCount() / sizeof($this->subTopics)) * 100;
    }

    private function getSubTopicCompleteCount(bool $stu): int
    {
            return $stu ?
                count(array_filter($this->subTopics, function ($subTopic) {
                return $subTopic->getStuIsCompleted() and $subTopic->getIsBeingTracked();
            })) :
                 count(array_filter($this->subTopics, function ($subTopic) {
                return $subTopic->getIsCovered() and $subTopic->getIsBeingTracked();
            }));
    }

    /**
     * @return int
     */
    public function getStuSubTopicCompleteCount(): int
    {
        return $this->getSubTopicCompleteCount(stu: true);
    }

    /**
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
