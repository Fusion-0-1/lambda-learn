<?php

namespace app\model;

use app\core\Application;
use app\core\User;
use app\core\Request;
use app\model\User\Lecturer;

class Course
{
    private string $courseCode;
    private string $courseName;
    private int $optionalFlag;
    private string $lecRegNo;
    private string $lecFirstName;
    private string $lecLastName;
    private array $courseTopics = [];

    private function __construct() {}

    public static function createNewCourse($courseCode, $courseName, $optionalFlag, $lecRegNo, $lecFirstName, $lecLastName, $courseTopics = []): Course {
        $course = new Course();
        $course->courseCode = $courseCode;
        $course->courseName = $courseName;
        $course->optionalFlag = $optionalFlag;
        $course->lecRegNo = $lecRegNo;
        $course->lecFirstName = $lecFirstName;
        $course->lecLastName = $lecLastName;
        $course->courseTopics = $courseTopics;

        return $course;
    }

    private static function getUserTable(User $user){
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            return 'StuCourse';
        } else if ($type == 'Lecturer') {
            return $user->isCoordinator() ? 'Course' : 'LecCourse';
        }
    }

    public static function getUserCourses(User $user): array
    {
        $courses = [];
        $table = Course::getUserTable($user);
        if ($table == 'Course') {
            $results = Application::$db->select(
                table: $table,
                columns: ['Course.course_code', 'Course.course_name', 'Course.optional_flag', 'LecCourse.lec_reg_no',
                    'AcademicStaff.first_name', 'AcademicStaff.last_name'],
                join: [
                    [
                        'table' => 'AcademicStaff',
                        'on' => 'AcademicStaff.reg_no = Course.cord_reg_no'
                    ],
                    [
                        'table' => 'LecCourse',
                        'on' => 'Course.course_code = LecCourse.course_code'
                    ]
                ],
                where: ['Course.cord_reg_no'=>$user->getRegNo()],
            );
        } elseif ($table == 'LecCourse'){
            $results = Application::$db->select(
                table: $table,
                columns: ['Course.course_code', 'Course.course_name', 'Course.optional_flag', 'LecCourse.lec_reg_no',
                    'AcademicStaff.first_name', 'AcademicStaff.last_name'],
                join: [
                    [
                        'table' => 'AcademicStaff',
                        'on' => 'LecCourse.lec_reg_no = AcademicStaff.reg_no'
                    ],
                    [
                        'table' => 'Course',
                        'on' => 'LecCourse.course_code = Course.course_code'
                    ]
                ],
                where: ['LecCourse.lec_reg_no'=>$user->getRegNo()],
            );
        } else {
            $results = Application::$db->select(
                table: $table,
                columns: ['StuCourse.course_code', 'Course.course_name', 'Course.optional_flag',
                    'LecCourse.lec_reg_no', 'AcademicStaff.first_name', 'AcademicStaff.last_name'],
                join: [
                    [
                        'table' => 'Course',
                        'on' => 'StuCourse.course_code = Course.course_code'
                    ],
                    [
                        'table' => 'LecCourse',
                        'on' => 'Course.course_code = LecCourse.course_code'
                    ],
                    [
                        'table' => 'AcademicStaff',
                        'on' => 'LecCourse.lec_reg_no = AcademicStaff.reg_no'
                    ]
                ],
                where: ['StuCourse.stu_reg_no' => $user->getRegNo()],
            );
        }
        while ($course = Application::$db->fetch($results)){
            $courses[] = self::createNewCourse(
                $course['course_code'],
                $course['course_name'],
                $course['optional_flag'],
                $course['lec_reg_no'],
                $course['first_name'],
                $course['last_name']
            );
        }
        return $courses;
    }

    public static function getCourse($courseCode): array
    {
        $courseDetails = [];
        $results = Application::$db->select(
                table: 'Course',
                columns: ['course_code', 'course_name'],
                where: ['course_code' => $courseCode]
            );
//        var_dump($results);
        while ($course = Application::$db->fetch($results)){
            $courseDetails[] = self::createNewCourse(
                $course['course_code'],
                $course['course_name'],
                $course['optional_flag'],
                $course['lec_reg_no'],
                $course['first_name'],
                $course['last_name'],
                CourseTopic::getCourseTopics($course['course_code'])
            );
        }
        return $courseDetails;
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

    /**
     * @param string $courseCode
     */
    public function setCourseCode(string $courseCode): void
    {
        $this->courseCode = $courseCode;
    }

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @param string $courseName
     */
    public function setCourseName(string $courseName): void
    {
        $this->courseName = $courseName;
    }

    /**
     * @return int
     */
    public function getOptionalFlag(): int
    {
        return $this->optionalFlag;
    }

    /**
     * @param int $optionalFlag
     */
    public function setOptionalFlag(int $optionalFlag): void
    {
        $this->optionalFlag = $optionalFlag;
    }

    /**
     * @return string
     */
    public function getLecRegNo(): string
    {
        return $this->lecRegNo;
    }

    /**
     * @param string $lecRegNo
     */
    public function setLecRegNo(string $lecRegNo): void
    {
        $this->lecRegNo = $lecRegNo;
    }

    /**
     * @return string
     */
    public function getLecFirstName(): string
    {
        return $this->lecFirstName;
    }

    /**
     * @param string $lecFirstName
     */
    public function setLecFirstName(string $lecFirstName): void
    {
        $this->lecFirstName = $lecFirstName;
    }

    /**
     * @return string
     */
    public function getLecLastName(): string
    {
        return $this->lecLastName;
    }

    /**
     * @param string $lecFirstName
     */
    public function setLecLastName(string $lecLastName): void
    {
        $this->lecLastName = $lecLastName;
    }

    /**
     * @return array
     */
    public function getTopics(): array
    {
        return $this->courseTopics;
    }

    /**
     * @param array $courseTopics
     */
    public function setTopics(array $courseTopics): void
    {
        $this->courseTopics = $courseTopics;
    }

};

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
        $subTopics->subTopics = $subTopics;

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
            $topics[] = self::createNewTopic(
                $topic['topic_id'],
                $topic['topic'],
                CourseSubTopic::getCourseSubTopics($topic['topic_id'], $topic['course_code'])
            );
        }
        return $topics;
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

    /**
     * @param string $courseCode
     */
    public function setCourseCode(string $courseCode): void
    {
        $this->courseCode = $courseCode;
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
}

class CourseSubTopic {
    private string $courseCode;
    private string $topicId;
    private string $subTopicId;
    private string $subTopicName;

    public function __construct() {}

    public static function createNewSubTopic($subTopicId, $subTopicName) {
        $subTopic = new CourseSubTopic();
        $subTopic->subTopicId = $subTopicId;
        $subTopic->subTopicName = $subTopicName;

        return $subTopic;
    }

    public static function getCourseSubTopics($topicId, $courseCode): array {
        $subTopics = [];
        $results = Application::$db->select(
            table: 'CourseSubTopic',
            columns: ['sub_topic_id', 'sub_topic'],
            where: ['course_code' => $courseCode, 'topic_id' => $topicId],
        );
        while ($subTopic = Application::$db->fetch($results)){
            $subTopics[] = self::createNewSubTopic(
                $subTopic['sub_topic_id'],
                $subTopic['sub_topic']
            );
        }
        return $subTopics;
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

    /**
     * @param string $courseCode
     */
    public function setCourseCode(string $courseCode): void
    {
        $this->courseCode = $courseCode;
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

}


