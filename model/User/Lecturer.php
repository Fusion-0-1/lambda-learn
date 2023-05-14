<?php

namespace app\model\User;

use app\core\Application;
use app\core\User;

class Lecturer extends User
{
    private string $degreeProgramCode;
    private string $position;

    // -------------------------------Constructors---------------------------------------
    private function __construct() {}

    public static function fetchLecFromDb(string $regNo)
    {
        $lecturer = new Lecturer();
        $table = $lecturer->getUserData($regNo);

        $lecturer->regNo = $table['reg_no'];
        $lecturer->firstName = $table['first_name'];
        $lecturer->lastName = $table['last_name'];
        $lecturer->email = $table['email'];
        $lecturer->personalEmail = $table['personal_email'];
        $lecturer->contactNo = $table['contact_no'];
        $lecturer->lastLogin = $table['last_login'];
        $lecturer->lastLogout = $table['last_logout'];
        $lecturer->activeStatus = $table['active_status'];
        $lecturer->profilePicture = $table['profile_picture'];
        $lecturer->degreeProgramCode = $table['degree_program_code'];
        $lecturer->position = $table['position'];

        return $lecturer;
    }

    public static function createNewLecturer($data)
    {
        $lecturer = new Lecturer();
        $lecturer->regNo = $data['regNo'];
        $lecturer->firstName = $data['firstName'];
        $lecturer->lastName = $data['lastName'];
        $lecturer->email = $data['email'];
        $lecturer->personalEmail = $data['personalEmail'];
        $lecturer->contactNo = $data['contactNo'];
        $lecturer->degreeProgramCode = $data['degreeProgramCode'] ?? '';
        $lecturer->position = $data['position'] ?? 'Lecturer';

        return $lecturer;
    }
    // --------------------------------------------------------------------------------


    /**
     * @description Insert new lecturer to database
     * @return string
     */
    public function insert(): string
    {
        $password = $this->generateRandomPassword();
        Application::$db->insert(
            table: 'AcademicStaff',
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
                'degree_program_code' => $this->degreeProgramCode ?? '',
                'position' => $this->position ?? 'Lecturer',
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]
        );
        return $password;
    }

    /**
     * @description Fetch all lecturers from database
     * @return array
     */
    public static function fetchLecturers()
    {
        $results = Application::$db->select(
            table: 'AcademicStaff',
            columns: ['reg_no', 'first_name', 'last_name']
        );
        $users = [];
        while ($row = Application::$db->fetch($results)) {
            $users[] = ['reg_no' => $row['reg_no'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name']];
        }
        return $users;
    }

    /**
     * @description Assign lecturers to courses
     * @param string $lecturer
     * @param string $courseCode
     * @return array
     */
    public static function assignLecturersToCourse(string $lecturer, string $courseCode)
    {
        $lecturerExists = [];
        $primaryKeys = ['lec_reg_no' => $lecturer,'course_code' => $courseCode];
        if(Application::$db->checkExists('LecCourse', $primaryKeys)){
            $lecturerExists[] = $lecturer;
        } else {
            Application::$db->insert(
                table: 'LecCourse',
                values: [
                    'lec_reg_no' => $lecturer,
                    'course_code' => $courseCode
                ]
            );
        }
        return $lecturerExists;
    }

    /**
     * @description Remove lecturer from course
     * @param $lecturer
     * @param $courseCode
     * @return bool
     */
    public static function removeLecturersFromCourse($lecturer, $courseCode)
    {
        $primaryKeys = ['lec_reg_no' => $lecturer,'course_code' => $courseCode];
        if(Application::$db->checkExists('LecCourse', $primaryKeys)){
            Application::$db->delete(
                table: 'LecCourse',
                where: ['course_code'=>$courseCode, 'lec_reg_no'=>$lecturer]
            );
            return true;
        } else {
            return false;
        }
    }


    /**
     * @description Get all coordinators
     * @return array
     */
    public static function fetchCoordinators(): array
    {
        $results = Application::$db->select(
            table: 'AcademicStaff',
            columns: ['reg_no', 'degree_program_code'],
            where: ['NOT degree_program_code' => ""]
        );

        $regNos = [];
        $degreeProgramCode = [];
        while ($row = Application::$db->fetch($results)) {
            $regNos[] = $row['reg_no'];
            $degreeProgramCode[] = $row['degree_program_code'];
        }
        return ['reg_no' => $regNos, 'degree_program_code' => $degreeProgramCode];
    }

    /**
     * @description Assign coordinator
     * @param string $regNo
     * @param string $degreeProgramCode
     * @return bool
     */
    public static function assignCoordinator(string $regNo, string $degreeProgramCode)
    {
        Application::$db->update(
            table: 'AcademicStaff',
            columns: ['degree_program_code' => $degreeProgramCode],
            where: ['reg_no' => $regNo]
        );
        return true;
    }

    /**
     * @description Remove singed coordinator
     * @param string $regNo
     * @return bool
     */
    public static function removeCoordinator(string $regNo)
    {
        Application::$db->update(
            table: 'AcademicStaff',
            columns: ['degree_program_code' => NULL],
            where: ['reg_no' => $regNo]
        );
        return true;
    }


    // ---------------------------Getters and Setters-----------------------------------
    /**
     * @description Get lecturer name from database using regNo
     * @param string $regNo
     * @return string
     */
    public static function getLecturerName(string $regNo)
    {
        $results = Application::$db->select(
            table: 'AcademicStaff',
            columns: ['first_name', 'last_name'],
            where: ['reg_no' => $regNo]
        );
        $row = Application::$db->fetch($results);
        return $row['first_name'] . ' ' . $row['last_name'];
    }

    /**
     * @description Check if the user is a coordinator
     * @return bool
     */
    public function isCoordinator(): bool
    {
        return $this->degreeProgramCode != '';
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