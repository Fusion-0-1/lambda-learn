<?php

namespace app\model;

use app\core\Application;

class Course
{
    private string $courseCode;
    private string $courseName;
    private int $optionalFlag;
    private string $lecRegNo;
    private string $lecFirstName;
    private string $lecLastName;

    private function __construct() {}
    
    public static function fetchCourseFromDb(string $regNo) {
        
        $table = self::getUserCourses($regNo);

        $course = new Course();
        $course->courseCode = $table['course_code'];
        $course->courseName = $table['course_name'];
        $course->optionalFlag = $table['optional_flag'];
        $course->lecRegNo = $table['lec_reg_no'];
        $course->lecFirstName = $table['first_name'];
        $course->lecLastName = $table['last_name'];

        return $course;
    }

    public static function createNewCourse($courseCode, $courseName, $optionalFlag, $lecRegNo, $lecFirstName, $lecLastName) {
        $course = new Course();
        $course->courseCode = $courseCode;
        $course->courseName = $courseName;
        $course->optionalFlag = $optionalFlag;
        $course->lecRegNo = $lecRegNo;
        $course->lecFirstName = $lecFirstName;
        $course->lecLastName = $lecLastName;

        return $course;
    }

    public static function getUserCourses($regNo): array
    {
        $courses = [];
        $results = Application::$db->select(
            table: 'StuCourse',
            columns: ['StuCourse.course_code', 'Course.course_name', 'Course.optional_flag', 'LecCourse.lec_reg_no', 'AcademicStaff.first_name', 'AcademicStaff.last_name'],
            join: [
                [
                    'table' =>'Course',
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
            where: ['StuCourse.stu_reg_no'=>$regNo],
        );
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

}


