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
    private array $lecsRegNo = [];
    private array $courseTopics = [];


    // -------------------------------Constructors---------------------------------------
    private function __construct() {}

    public static function createNewCourse($courseCode, $courseName, $optionalFlag,
                                           $lecsRegNo=[], $courseTopics = []): Course {
        $course = new Course();
        $course->courseCode = $courseCode;
        $course->courseName = $courseName;
        $course->optionalFlag = $optionalFlag;
        $course->lecsRegNo = $lecsRegNo;
        $course->courseTopics = $courseTopics;
        return $course;
    }
    // --------------------------------------------------------------------------------



    // -----------------------------Basic Methods-------------------------------------
    /**
     * @description Get the course detail table relevant to the user based on the user type
     * @param User $user
     * @return string|void
     */
    private static function getUserTable(User $user){
        $type = $user::getUserType($user->getRegNo());
        if ($type == 'Student') {
            return 'StuCourse';
        } else if ($type == 'Lecturer') {
            return $user->isCoordinator() ? 'Course' : 'LecCourse';
        }
    }

    /**
     * @description Get all the courses relevant to the user
     * @param User $user
     * @return array
     */
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
                lecsRegNo: self::getCourseLecturers($course['course_code']),
                courseTopics: CourseTopic::getCourseTopics($course['course_code']),
            );
        }
        return $courses;
    }

    /**
     * @description Get course lecturer registration numbers of a given course
     * @param string $courseCode
     * @return array
     */
    public static function getCourseLecturers(string $courseCode): array
    {
        $results = Application::$db->select(
            table: 'LecCourse',
            columns: ['lec_reg_no'],
            where: ['course_code'=> $courseCode]
        );

        $courseLecturers = [];
        while ($courseLec = Application::$db->fetch($results)) {
            $courseLecturers[] = $courseLec['lec_reg_no'];
        }
        return $courseLecturers;
    }

    /**
     * @description Check whether a course exists
     * @param string $course
     * @return bool
     */
    public static function checkExists(string $course) : bool
    {
        return Application::$db->checkExists('Course', ['course_code' => $course]);
    }

    /**
     * @description Get the course details of a given course
     * @param string $courseCode
     * @return Course
     */
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

    /**
     * @description Get details of all the courses in the database
     * @return array
     */
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

    /**
     * @description Insert a new course to the database
     * @param string $courseCode
     * @param string $courseName
     * @param int $isOptional
     * @return bool
     */
    public static function insertCourse(string $courseCode, string $courseName, int $isOptional, string $cordRegNo) : bool
    {
        if(!self::checkExists($courseCode)) {
            Application::$db->insert(
                table: 'Course',
                values: [
                    'course_code' => $courseCode,
                    'course_name' => $courseName,
                    'optional_flag' => $isOptional,
                    'cord_reg_no' => $cordRegNo,
                    'date_created' => date('Y-m-d')
                ]
            );
            return true;
        }
        return false;
    }

    /**
     * @description Update the course details of a given course
     * @param string $courseCode
     * @param string $courseName
     * @return bool
     */
    public static function UpdateCourse(string $courseCode, string $courseName) : bool
    {
        Application::$db->update(
            table: 'Course',
            columns: ['course_name' => $courseName],
            where: ['course_code' => $courseCode]
        );
        return true;
    }

    /**
     * @description Delete a course from the database
     * @param string $courseCode
     * @return bool
     */
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

    /**
     * @description Get the number of topics of a given course
     * @param string $courseCode
     * @return int
     */
    public static function getTopicCount(string $courseCode) : int
    {
        $results = Application::$db->select(
            table: 'CourseTopic',
            columns: ['topic_id'],
            where: ['course_code'=>$courseCode]
        );
        return Application::$db->rowCount($results);
    }

    public static function getStuAssignedCount(string $courseCode)
    {
        $students = Application::$db->select(
            table: 'StuCourse',
            columns: ['stu_reg_no'],
            where: ['course_code'=>$courseCode]
        );
        return Application::$db->rowCount($students);
    }

    /**
     * @description Add new topics and sub topics to a given course
     * @param $courseCode
     * @param $topics
     * @param $subTopics
     * @param $lecRegNo
     * @return true
     */
    public static function addNewTopicsAndSubTopics($courseCode, $topics, $subTopics, $lecRegNo)
    {
        $lastTopicId = Application::$db->select(
            table: 'CourseTopic',
            columns: ['topic_id'],
            where:  ['course_code' => $courseCode]
        );
        $topicId = Application::$db->rowCount($lastTopicId)+1;
        $subTopicCount = 0;
        foreach ($topics as $topic){
            if($topic != ''){
                $subTopicId = 0;
                Application::$db->insert(
                    table: 'CourseTopic',
                    values: ['course_code' => $courseCode, 'topic_id' => $topicId, 'topic' => $topic]
                );
                foreach ($subTopics[$subTopicCount] as $subTopic){
                    $subTopicIdFormat = ($topicId) . '.' . sprintf('%02d', ($subTopicId+1));
                    Application::$db->insert(
                        table: 'CourseSubTopic',
                        values: ['course_code' => $courseCode, 'topic_id' => $topicId, 'sub_topic_id' => $subTopicIdFormat,
                            'sub_topic' => $subTopic, 'lec_reg_no' => $lecRegNo ]
                    );
                    $subTopicId++;
                }
                $subTopicCount++;
                $topicId++;
            }
        }
        return true;
    }

    public static function unwrapExamMarks(array $line): array
    {
        return[
            'regNo' => trim($line[0]),
            'marks' => trim($line[1])
        ];
    }

    public static function updateExamMarks($regNo, $courseCode, $marks, $path): bool
    {
        Application::$db->update(
            table: 'StuCourse',
            columns: ['exam_marks' => $marks],
            where: ['stu_reg_no' => $regNo, 'course_code' => $courseCode]
        );

        Application::$db->update(
            table: 'Course',
            columns: ['exam_marks_report_path' => $path],
            where: ['course_code' => $courseCode]
        );
        return true;
    }

    public static function updateSubmissionMarks($regNo, $courseCode, $submissionId, $marks): bool
    {
        $allocatedMarksAndPoints = Application::$db->select(
            table: 'CourseSubmission',
            columns: ['allocated_mark', 'allocated_point'],
            where: ['course_code'=>$courseCode, 'submission_id'=>$submissionId]
        );
        $markAndPoint = Application::$db->fetch($allocatedMarksAndPoints);
        $points = ((int)$marks / (int)$markAndPoint['allocated_mark'] ) * (int)$markAndPoint['allocated_point'];
        Application::$db->update(
            table: 'StuCourseSubmission',
            columns: ['stu_submission_point' => $points,'stu_submission_mark' => $marks],
            where: ['stu_reg_no' => $regNo, 'course_code' => $courseCode, 'submission_id'=>$submissionId]
        );
        return true;
    }

    /*
     * @description delete all the stu courses
     */
    public static function truncateStuCourses()
    {
        Application::$db->truncateTable('StuCourse');
    }

    public static function removeCourseAnnouncements($courseCode)
    {
        Application::$db->delete(
            table: 'CourseAnnouncement',
            where: ['course_code'=>$courseCode]
        );
    }

    public static function removeCourseSubToicsAndTopics($courseCode)
    {
        Application::$db->delete(
            table: 'CourseSubTopic',
            where: ['course_code'=>$courseCode]
        );
        Application::$db->delete(
            table: 'CourseTopic',
            where: ['course_code'=>$courseCode]
        );
    }

    // ---------------------------Getters and Setters-----------------------------------

    /**
     * @description Get total topic completion progress
     * @param bool $stu
     * @return int
     */
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
        return (int)($subTopicCount ?  $count/$subTopicCount * 100 : $subTopicCount);
    }

    /**
     * @description Get total topic completion progress for lecturer
     * @return int
     */
    public function getLecTotalTopicCompletionProgress(): int
    {
        return $this->getTotalTopicCompletionProgress(stu: false);
    }

    /**
     * @description Get total topic completion progress for student
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
    public function getLecsRegNo(): array
    {
        return $this->lecsRegNo;
    }

    /**
     * @param string $lecRegNo
     */
    public function setLecRegNo(array $lecsRegNo): void
    {
        $this->lecsRegNo = $lecsRegNo;
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




