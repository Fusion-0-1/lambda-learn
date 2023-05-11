<?php

namespace app\model;

use app\core\Application;
use app\core\User;
use app\core\Request;
use app\model\User\Lecturer;
use PhpParser\Node\Expr\Cast\Bool_;

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
                columns: ['course_code', 'course_name', 'optional_flag'],
                where: ['cord_reg_no'=>$user->getRegNo()],
            );
        } elseif ($table == 'LecCourse'){
            $results = Application::$db->select(
                table: $table,
                columns: ['Course.course_code', 'Course.course_name', 'Course.optional_flag'],
                join: [
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
                columns: ['StuCourse.course_code', 'Course.course_name', 'Course.optional_flag'],
                join: [
                    [
                        'table' => 'Course',
                        'on' => 'StuCourse.course_code = Course.course_code'
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
//                lecRegNo: $course['lec_reg_no'],
//                lecFirstName: $course['first_name'],
//                lecLastName: $course['last_name'],
                courseTopics: CourseTopic::getCourseTopics($course['course_code']),
            );
        }
        return $courses;
    }

    public static function checkExists(string $course) : bool
    {
        return Application::$db->checkExists('Course', ['course_code' => $course]);
    }

    public static function getCourse(string $courseCode): Course
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

    public static function fetchAllCourses() : array
    {
        $results = Application::$db->select(
            table: 'Course',
            columns: ['course_code', 'course_name', 'date_created'],
        );
        $courses = [];
        while ($row = Application::$db->fetch($results)) {
            $courses[] = ['course_code' => $row['course_code'], 'course_name' => $row['course_name'],
                'date_created'=>$row['date_created']];
        }
        return $courses;
    }

    public static function insertCourse(string $courseCode,string $courseName,int $isOptional) : bool
    {
        if(!self::checkExists($courseCode)) {
            Application::$db->insert(
                table: 'Course',
                values: [
                    'course_code' => $courseCode,
                    'course_name' => $courseName,
                    'optional_flag' => $isOptional,
                    'date_created' => date('Y-m-d')
                ]
            );
            return true;
        }
        return false;
    }

    public static function UpdateCourse(string $courseCode,string $courseName) : bool
    {
        Application::$db->update(
            table: 'Course',
            columns: ['course_name' => $courseName],
            where: ['course_code' => $courseCode]
        );
        return true;
    }

    public static function deleteCourse(string $courseCode) : bool
    {
        $lecCount = Application::$db->select(
          table: 'LecCourse',
          where: ['course_code'=>$courseCode]
        );
        if(Application::$db->rowCount($lecCount)>0){
            Application::$db->delete(
                table: 'LecCourse',
                where: ['course_code'=>$courseCode]
            );
        }
        Application::$db->delete(
            table: 'CourseSubmission',
            where: ['course_code'=>$courseCode]
        );
        Application::$db->delete(
            table: 'Course',
            where: ['course_code'=>$courseCode]
        );
        return true;
    }

    public static function getTopicCount(string $courseCode) : int
    {
        $results = Application::$db->select(
            table: 'CourseTopic',
            columns: ['topic_id'],
            where: ['course_code'=>$courseCode]
        );
        return Application::$db->rowCount($results);
    }

    // ---------------------------Getters and Setters-----------------------------------

    private function getTotalTopicCompletionProgress(bool $stu):int
    {
        $count = 0;
        $subTopicCount = 0;
        foreach ($this->courseTopics as $topic){
            $count += $stu ? $topic->getStuSubTopicCompleteCount() : $topic->getLecSubTopicCompleteCount();
            $subTopicCount += sizeof(array_filter($topic->getSubTopics(), function ($subTopic) {
                return $subTopic->getIsBeingTracked();
            }));
        }
        return $subTopicCount ?  $count/$subTopicCount * 100 : $subTopicCount ;
    }

    /**
     * @return int
     */
    public function getLecTotalTopicCompletionProgress(): int
    {
        return $this->getTotalTopicCompletionProgress(stu: false);
    }

    /**
     * @return int
     */
    public function getStuTotalTopicCompletionProgress(): int
    {
        return $this->getTotalTopicCompletionProgress(stu: true);
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




