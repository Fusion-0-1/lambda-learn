<?php

namespace app\model;

use app\core\Application;

class CourseTopic {
    private string $courseCode;
    private string $topicId;
    private string $topicName;
    private array $subTopics = [];

    public function __construct() {}
    public static function createNewTopic($topicId, $topicName, $subTopics = []): CourseTopic
    {
        $topic = new CourseTopic();
        $topic->topicId = $topicId;
        $topic->topicName = $topicName;
        $topic->subTopics = $subTopics;

        return $topic;
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
}
