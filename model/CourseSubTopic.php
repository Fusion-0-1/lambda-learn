<?php

namespace app\model;

use app\core\Application;

/**
 *
 */
class CourseSubTopic {
    private string $courseCode;
    private string $topicId;
    private string $subTopicId;
    private string $subTopicName;
    private int $isBeingTracked;
    private int $isCovered;
    private int $stuIsCompleted;
    private string $location;
    private array $subTopicRecs = [];

    public function __construct() {}

    /**
     * @param $subTopicId
     * @param $subTopicName
     * @param $isBeingTracked
     * @param $isCovered
     * @param $stuIsCompleted
     * @param $subTopicRecs
     * @param $location
     * @return CourseSubTopic
     */
    public static function createNewSubTopic($subTopicId, $subTopicName='', $isBeingTracked=0, $isCovered=0, $stuIsCompleted=0, $subTopicRecs = [], $location=''): CourseSubTopic {
        $subTopic = new CourseSubTopic();
        $subTopic->subTopicId = $subTopicId;
        $subTopic->subTopicName = $subTopicName;
        $subTopic->isBeingTracked = $isBeingTracked;
        $subTopic->isCovered = $isCovered;
        $subTopic->stuIsCompleted = $stuIsCompleted;
        $subTopic->subTopicRecs = $subTopicRecs;
        $subTopic->location = $location;

        return $subTopic;
    }

    /**
     * @description Get course sub topics from the database
     * @param $topicId
     * @param $courseCode
     * @return array
     */
    public static function getCourseSubTopics($topicId, $courseCode): array
    {
        $subTopics = [];
        $results = Application::$db->select(
            table: 'CourseSubTopic',
            columns: ['sub_topic_id', 'sub_topic', 'is_being_tracked', 'is_covered'],
            where: ['course_code' => $courseCode, 'topic_id' => $topicId]
        );

        // Fetch stuCourseSubTopic to an array
        if($_SESSION['user-role'] == 'Student'){
            $user = unserialize($_SESSION['user']);
            $regNo = $user->getregNo();
            $completedSubTopics = Application::$db->select(
                table: 'StuCourseSubTopic',
                columns: ['sub_topic_id'],
                where: ['course_code' => $courseCode, 'stu_reg_no' => $regNo, 'topic_id' => $topicId, 'is_completed' => 1]
            );


            $completedSubTopicIds = [];
            foreach ($completedSubTopics as $completedSubTopic) {
                $completedSubTopicIds[] = $completedSubTopic['sub_topic_id'];
            }

            while ($subTopic = Application::$db->fetch($results)) {
                // Check if subTopicId exists in completedSubTopicIds
                $stuIsCompleted = in_array($subTopic['sub_topic_id'], $completedSubTopicIds) ? 1 : 0;
                $subTopicRecs = CourseSubTopic::getCourseSubTopicRecs($subTopic['sub_topic_id'], $topicId, $courseCode);
                $subTopics[] = self::createNewSubTopic(
                    subTopicId: $subTopic['sub_topic_id'],
                    subTopicName: $subTopic['sub_topic'],
                    isBeingTracked: $subTopic['is_being_tracked'],
                    isCovered: $subTopic['is_covered'],
                    stuIsCompleted: $stuIsCompleted,
                    subTopicRecs: $subTopicRecs
                );
            }

        } else {
            while ($subTopic = Application::$db->fetch($results)){
                $subTopicRecs = CourseSubTopic::getCourseSubTopicRecs($subTopic['sub_topic_id'], $topicId, $courseCode);
                $subTopics[] = self::createNewSubTopic(
                    subTopicId: $subTopic['sub_topic_id'],
                    subTopicName: $subTopic['sub_topic'],
                    isBeingTracked: $subTopic['is_being_tracked'],
                    isCovered: $subTopic['is_covered'],
                    subTopicRecs: $subTopicRecs
                );
            }
        }
        return $subTopics;
    }

    /**
     * @description Insert course sub topics to the database
     * @param $courseCode
     * @param $lec_reg_no
     * @param $topicsArray
     * @param $subTopicsArray
     * @param $chekboxes
     * @return void
     */
    public function insertCourseSubTopics($courseCode, $lec_reg_no, $topicsArray, $subTopicsArray, $chekboxes)
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

    /**
     * @description Update course sub topics progress in the database
     * @param string $courseCode
     * @param int $topicId
     * @param $subTopicId
     * @return string|void
     */
    public static function updateProgress(string $courseCode, int $topicId, $subTopicId)
    {
        if($_SESSION['user-role']=='Lecturer'){
            Application::$db->update(
                table: 'CourseSubTopic',
                columns: ['is_covered' => 1],
                where: ['course_code' => $courseCode,'topic_id' => $topicId, 'sub_topic_id' => $subTopicId]
            );
        } else {
            $user = unserialize($_SESSION['user']);
            $regNo = $user->getregNo();

            $isCompletedByStu = Application::$db->select(
                table: 'StuCourseSubTopic',
                columns: ['is_completed'],
                where: ['course_code' => $courseCode,'topic_id' => $topicId, 'sub_topic_id' => $subTopicId,
                    'stu_reg_no' => $regNo]
            );
            if(Application::$db->fetch($isCompletedByStu)['is_completed'] == "1"){
                Application::$db->update(
                    table: 'StuCourseSubTopic',
                    columns: ['is_completed' => 0],
                    where: ['course_code' => $courseCode,'topic_id' => $topicId, 'sub_topic_id' => $subTopicId,
                        'stu_reg_no' => $regNo]
                );
            } else {
                $isCoveredByLec = Application::$db->select(
                    table: 'CourseSubTopic',
                    columns: ['is_covered'],
                    where: ['course_code' => $courseCode,'topic_id' => $topicId, 'sub_topic_id' => $subTopicId]
                );
                if( Application::$db->fetch($isCoveredByLec)['is_covered'] == "1"){
                    Application::$db->update(
                        table: 'StuCourseSubTopic',
                        columns: ['is_completed' => 1],
                        where: ['course_code' => $courseCode,'topic_id' => $topicId, 'sub_topic_id' => $subTopicId,
                            'stu_reg_no' => $regNo]
                    );
                } else {
                    return 'Failed';
                }
            }
        }
    }

    /**
     * @description Edit course sub topics in the database
     * @param $courseCode
     * @param $topicId
     * @param $subTopicId
     * @param $subTopicName
     * @return bool
     */
    public static function editSubTopics($courseCode, $topicId, $subTopicId, $subTopicName) : bool
    {
        Application::$db->update(
            table: 'CourseSubTopic',
            columns: ['sub_topic' => $subTopicName],
            where: ['course_code' => $courseCode, 'topic_id' => $topicId, 'sub_topic_id' => $subTopicId]
        );
        return true;
    }

    /**
     * @description Check if a lecture recording exists in the database
     * @param $courseCode
     * @param $courseTopic
     * @param $courseSubTopic
     * @param $location
     * @return bool
     */
    public static function lecturerRecordingExits($courseCode, $courseTopic, $courseSubTopic, $location): bool
    {
        return Application::$db->checkExists(
            table: 'coursesubtopicrec',
            primaryKey: ['course_code'=>$courseCode,'topic_id'=>$courseTopic,'sub_topic_id'=>$courseSubTopic,'recording'=>$location]
        );
    }

    /**
     * @description Get all the recordings of a sub topic
     * @param $subTopicId
     * @param $topicId
     * @param $courseCode
     * @return array
     */
    public static function getCourseSubTopicRecs($subTopicId, $topicId, $courseCode): array
    {
        $recordings = [];
        $results = Application::$db->select(
            table: 'coursesubtopicrec',
            columns: ['sub_topic_id', 'recording'],
            where: ['sub_topic_id'=>$subTopicId,'topic_id'=>$topicId,'course_code'=>$courseCode]
        );
       while ($recording = Application::$db->fetch($results)){
           $recordings[] = self::createNewSubTopic(
               subTopicId: $recording['sub_topic_id'],
               location: $recording['recording']
           );
       }
         return $recordings;
    }

    /**
     * @description Insert a lecturer recording into the database
     * @param $courseCode
     * @param $topicId
     * @param $subtopicId
     * @param $location
     * @return void
     */
    public static function insertLecturerRecording($courseCode, $topicId, $subtopicId, $location)
    {
        Application::$db->insert(
            table: 'coursesubtopicrec',
            values: [
                'course_code' => $courseCode,
                'topic_id' => $topicId,
                'sub_topic_id' => $subtopicId,
                'recording'=>$location
            ]
        );
    }

    /**
     * @description Delete student course sub topics from the database
     * @return void
     */
    public static function truncateStuCourseSubTopics()
    {
        Application::$db->truncateTable('StuCourseSubTopic');
    }

    /**
     * @param $courseCode
     * @return void
     */
    public static function removeSlidesAndRecordings($courseCode)
    {
        Application::$db->delete(
            table: 'CourseSubTopicRec',
            where: ['course_code'=>$courseCode]
        );
        Application::$db->delete(
            table: 'CourseSubTopicSlide',
            where: ['course_code'=>$courseCode]
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

    /**
     * @return int
     */
    public function getStuIsCompleted(): int
    {
        return $this->stuIsCompleted;
    }

    /**
     * @param int $stuIsCompleted
     */
    public function setStuIsCompleted(int $stuIsCompleted): void
    {
        $this->stuIsCompleted = $stuIsCompleted;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return array
     */
    public function getSubTopicRecs(): array
    {
        return $this->subTopicRecs;
    }

    /**
     * @param array $subTopicRecs
     */
    public function setSubTopicRecs(array $subTopicRecs): void
    {
        $this->subTopicRecs = $subTopicRecs;
    }
}
