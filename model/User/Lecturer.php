<?php

namespace app\model\User;

use app\core\Application;
use app\core\User;

class Lecturer extends User
{
    private string $degreeProgramCode;

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

        return $lecturer;
    }
    // --------------------------------------------------------------------------------



    public function insert()
    {
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
                'degree_program_code' => $this->degreeProgramCode,
                'password' => password_hash($this->regNo, PASSWORD_DEFAULT)
            ]
        );
    }



    // ---------------------------Getters and Setters-----------------------------------
    public function isCoordinator(): bool
    {
        return $this->degreeProgramCode != null;
    }
    // --------------------------------------------------------------------------------
}