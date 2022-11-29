<?php

namespace app\model;

use app\core\Application;
use app\core\User;

class Student extends User
{
    private string $regNo;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $personalEmail;
    private string $contactNo;
    private string $lastLogin;
    private string $lastLogout;
    private bool $activeStatus;
    private string $profilePicture;
    private int $indexNo;
    private string $dateJoined;
    private string $degreeProgramCode;

    /**
     * @param string $regNo
     */
    public function __construct(string $regNo)
    {
        $table = $this->getUserData($regNo);
        $this->regNo = $table['reg_no'];
        $this->firstName = $table['first_name'];
        $this->lastName = $table['last_name'];
        $this->email = $table['email'];
        $this->personalEmail = $table['personal_email'];
        $this->contactNo = $table['contact_no'];
        $this->lastLogin = $table['last_login'];
        $this->lastLogout = $table['last_logout'];
        $this->activeStatus = $table['active_status'];
        $this->profilePicture = $table['profile_picture'];
        $this->indexNo = $table['index_no'];
        $this->dateJoined = $table['date_joined'];
        $this->degreeProgramCode = $table['degree_program_code'];
    }
}