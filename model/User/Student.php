<?php

namespace app\model\User;

use app\core\Application;
use app\core\User;

class Student extends User
{
    private int $indexNo;
    private string $dateJoined;
    private string $degreeProgramCode;


    // -------------------------------Constructors---------------------------------------
    private function __construct() {}

    public static function fetchStuFromDb(string $regNo)
    {
        $student = new Student();
        $table = $student->getUserData($regNo);

        $student->regNo = $table['reg_no'];
        $student->firstName = $table['first_name'];
        $student->lastName = $table['last_name'];
        $student->email = $table['email'];
        $student->personalEmail = $table['personal_email'];
        $student->contactNo = $table['contact_no'];
        $student->lastLogin = $table['last_login'];
        $student->lastLogout = $table['last_logout'];
        $student->activeStatus = $table['active_status'];
        $student->profilePicture = $table['profile_picture'];
        $student->indexNo = $table['index_no'];
        $student->dateJoined = $table['date_joined'];
        $student->degreeProgramCode = $table['degree_program_code'];

        return $student;
    }

    public static function createNewStudent($data)
    {
        $student = new Student();
        $student->regNo = $data['regNo'];
        $student->firstName = $data['firstName'];
        $student->lastName = $data['lastName'];
        $student->email = $data['email'];
        $student->personalEmail = $data['personalEmail'];
        $student->contactNo = $data['contactNo'];
        $student->indexNo = $data['indexNo'] ?? self::getIndexNoByRegNo($data['regNo']);
        $student->dateJoined = $data['dateJoined'] ?? date('Y-m-d H:i:s', time());
        $student->degreeProgramCode = $data['degreeProgramCode'] ?? self::getDegreeProgramCodeByRegNo($data['regNo']);

        return $student;
    }
    // --------------------------------------------------------------------------------



    // -----------------------------Basic Methods-------------------------------------
    /**
     * @description Insert new student to database
     * @return string
     */
    public function insert(): string
    {
        $password = $this->generateRandomPassword();
        Application::$db->insert(
            table: 'Student',
            values: [
                'reg_no' => $this->regNo,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'personal_email' => $this->personalEmail,
                'contact_no' => $this->contactNo,
                'last_login' => $this->lastLogin ?? date('Y-m-d H:i:s', time()),
                'last_logout' => $this->lastLogout ?? date('Y-m-d H:i:s', time()),
                'active_status' => $this->activeStatus ?? 0,
                'profile_picture' => $this->profilePicture ?? '',
                'index_no' => $this->indexNo,
                'date_joined' => $this->dateJoined,
                'degree_program_code' => $this->degreeProgramCode,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]
        );
        return $password;
    }
    // --------------------------------------------------------------------------------



    // -----------------------------Custom Methods-------------------------------------
    /**
     * @description Update course attendance of a student
     * @param $courseCode
     * @return void
     */
    public function updateCourseAttendance($courseCode)
    {
        Application::$db->update(
            table: 'StuCourseSubmission',
            columns: ['stu_submission_point' => 'stu_submission_point + 10'],
            where: [
                'stu_reg_no' => $this->regNo,
                'course_code' => $courseCode,
                'submission_id' => 'A001'
                ],
            math_formulae: true
        );
    }

    /**
     * @description Update attendance of all courses
     * @param $courses
     * @param $attendance
     * @return void
     */
    public function updateAllCoursesAttendance($courses, $attendance)
    {
        for ($i = 0; $i < count($courses); $i++) {
            if (trim($attendance[$i]) == '1') {
                $this->updateCourseAttendance($courses[$i]);
            }
        }
    }

    /**
     * @description Fetch students according to the given degree program code
     * @return array
     */
    public static function fetchStudents()
    {
        $results = Application::$db->select(
            table: 'Student',
            columns: ['reg_no', 'degree_program_code']
        );
        $users = [];
        while ($row = Application::$db->fetch($results)) {
            $users[] = ['reg_no' => $row['reg_no'], 'degree_program_code' => $row['degree_program_code']];
        }
        return $users;
    }

    /**
     * @description Assign students to a course
     * @param string $regNoLike
     * @param string $courseCode
     * @return array
     */
    public static function assignStudentsToCourse(string $regNoLike, string $courseCode)
    {
        $semester = explode(' ', $courseCode);
        $values = Application::$db->select(
            table: 'Student',
            columns: ['reg_no'],
            like: ['reg_no' => $regNoLike],
        );
        $studentExists = [];
        while ($student = Application::$db->fetch($values)){
            $primaryKeys = ['stu_reg_no' => $student['reg_no'],'course_code' => $courseCode];
            if(Application::$db->checkExists('StuCourse', $primaryKeys)){
                $studentExists[] = $student['reg_no'];
            } else {
                Application::$db->insert(
                    table: 'StuCourse',
                    values: [
                        'stu_reg_no' => $student['reg_no'],
                        'course_code' => $courseCode,
                        'semester' =>  $semester[1][1]
                    ]
                );
            }
        }
        return $studentExists;
    }
    // --------------------------------------------------------------------------------



    // -------------------------Field validation methods---------------------------------
    /**
     * @param $regNo
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $contactNo
     * @param $personalEmail
     * @param $indexNo
     * @param $degreeProgramCode
     * @return bool
     */
    public static function validateUserAttributes($regNo, $firstName, $lastName, $email, $contactNo,
                                                  $personalEmail=null, $indexNo=null, $degreeProgramCode=null): bool
    {
        if(
            // Not null checks
            $degreeProgramCode != ''
        ) {
            /*
             * ^: This matches the start of the string.
             * \d{8}: This matches 8 consecutive digits. This is the part of the pattern that ensures that the string contains exactly 8 digits.
             * $: This matches the end of the string.
             */
            if (!self::validateIndexNo($indexNo)) {
                return false;
            }
        } else {
            return false;
        }
        return parent::validateUserAttributes($regNo, $firstName, $lastName, $email, $contactNo);
    }

    /**
     * @param $indexNo
     * @return bool
     */
    public static function validateIndexNo($indexNo): bool
    {
        /*
         * ^: This matches the start of the string.
         * \d{10}: This matches 10 consecutive digits. This is the part of the pattern that ensures that the string contains exactly 10 digits.
         * $: This matches the end of the string.
         */
        return preg_match("/^\d{8}$/", $indexNo);
    }
    // --------------------------------------------------------------------------------



    // ---------------------------Getters and Setters-----------------------------------
    /**
     * @param array $regNos
     * @return array
     */
    public static function getBatchYears(array $regNos)
    {
        $uniqueYears = []; // Array to store unique years
        foreach ($regNos as $regNo) {
            $batchYear = explode('/', $regNo, 3)[0]; // Get batch year from regNo
            if (!in_array($batchYear, $uniqueYears)) {
                // If batch year is not already in uniqueYears array, add it
                $uniqueYears[] = $batchYear;
            }
        }
        return $uniqueYears;
    }

    /**
     * @description Get unique degree programs
     * @param array $degreePrograms
     * @return array
     */
    public static function getDegreePrograms(array $degreePrograms)
    {
        $uniqueDegreePrograms = [];
        foreach ($degreePrograms as $degreeProgram) {// Get batch year from regNo
            if (!in_array($degreeProgram, $uniqueDegreePrograms)) {
                $uniqueDegreePrograms[] = $degreeProgram;
            }
        }
        return $uniqueDegreePrograms;
    }

    /**
     * @param $regNo
     * @return string
     */
    public static function getDegreeProgramCodeByRegNo($regNo): string
    {
        return strtoupper(explode('/', $regNo, 3)[1]);
    }

    /**
     * @param $regNo
     * @return int
     */
    public static function getIndexNoByRegNo($regNo): int
    {
        $splits = explode('/', $regNo, 3);
        return (int)($splits[0] . $splits[2]);
    }

    /**
     * @return int
     */
    public function getIndexNo(): int
    {
        return $this->indexNo;
    }

    /**
     * @return string
     */
    public function getDateJoined(): string
    {
        return $this->dateJoined;
    }

    /**
     * @param string $dateJoined
     */
    public function setDateJoined(string $dateJoined): void
    {
        $this->dateJoined = $dateJoined;
    }

    /**
     * @return string
     */
    public function getDegreeProgramCode(): string
    {
        return $this->degreeProgramCode;
    }

    /**
     * @param string $degreeProgramCode
     */
    public function setDegreeProgramCode(string $degreeProgramCode): void
    {
        $this->degreeProgramCode = $degreeProgramCode;
    }
    // --------------------------------------------------------------------------------

}