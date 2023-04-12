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



    // -------------------------------Constructors---------------------------------------
    private function __construct() {}

    public static function createNewCourse($courseCode, $courseName, $optionalFlag,
                                           $lecRegNo='', $lecFirstName='', $lecLastName='', $courseTopics = []): Course {
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
    // --------------------------------------------------------------------------------



    // -----------------------------Basic Methods-------------------------------------
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
                courseCode: $course['course_code'],
                courseName: $course['course_name'],
                optionalFlag: $course['optional_flag'],
                lecRegNo: $course['lec_reg_no'],
                lecFirstName: $course['first_name'],
                lecLastName: $course['last_name']
            );
        }
        return $courses;
    }

    public static function checkExists($course)
    {
        return Application::$db->checkExists('Course', ['course_code' => $course]);
    }

    public static function getCourse($courseCode): Course
    {
        $results = Application::$db->select(
            table: 'Course',
            columns: ['course_code', 'course_name', 'optional_flag'],
            where: ['course_code' => $courseCode]
        );
        $course = Application::$db->fetch($results);
        $courseTopics = CourseTopic::getCourseTopics($course['course_code']);
        return self::createNewCourse(
            courseCode: $course['course_code'],
            courseName: $course['course_name'],
            optionalFlag: (int) $course['optional_flag'],
            courseTopics: $courseTopics
        );

    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @return int
     */
    public function getLecTotalTopicCompletionProgress(): int
    {
        $count = 0;
        $subTopicCount = 0;
        foreach ($this->courseTopics as $topic){
            $count = $count + $topic->getLecSubTopicCompleteCount();
            $subTopicCount = $subTopicCount + sizeof($topic->getSubTopics());
        }
        return $count/$subTopicCount * 100;
    }

    /**
     * @return int
     */
    public function getStuTotalTopicCompletionProgress():int{
        $count = 0;
        $subTopicCount = 0;
        foreach ($this->courseTopics as $topic){
            $count = $count + $topic->getStuSubTopicCompleteCount();
            $subTopicCount = $subTopicCount + sizeof($topic->getSubTopics());
        }
        return $count/$subTopicCount * 100;
    }

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
    // --------------------------------------------------------------------------------
};




