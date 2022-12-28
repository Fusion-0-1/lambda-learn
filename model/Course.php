<?php

namespace app\model;

use app\core\Application;

class Course
{
    private string $courseCode;
    private string $courseName;
    private int $optionalFlag;
    private string $lecRegNo;

    private function __construct() {}
    
    public static function fetchCourseFromDb(string $regNo) {
        $course = new Course();
        $table = $course->getUserCourses($regNo);

        $course->courseCode = $table['course_code'];
        $course->courseName = $table['course_name'];
        $course->optionalFlag = $table['optional_flag'];
        $course->lecRegNo = $table['lec_reg_no'];

        return $course;
    }

    public static function createNewCourse($courseCode, $courseName, $optionalFlag, $lecRegNo) {
        $course = new Course();
        $course->courseCode = $courseCode;
        $course->courseName = $courseName;
        $course->optionalFlag = $optionalFlag;
        $course->lecRegNo = $lecRegNo;

        return $course;
    }

    protected function getUserCourses($regNo): array
    {
        $coursesArray = Application::$db->select(
            table: 'StuCourse',
            columns: ['StuCourse.course_code', 'Course.course_name', 'Course.optional_flag', 'LecCourse.lec_reg_no'],
            join: ['Course ON StuCourse.course_code=Course.course_code JOIN LecCourse ON StuCourse.course_code=LecCourse.course_code'],
            where: ['StuCourse.stu_reg_no'=>$regNo],
            getAsArray: false,
        );

        $courses = Application::$db->fetch($coursesArray);

        $course = Application::$db->rowCount($courses);

        return Application::$db->setEmptyToNullColumns($course);
    }
    

}


