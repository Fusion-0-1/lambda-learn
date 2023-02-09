<?php

namespace app\model\User;

use app\core\Application;
use app\core\User;

class Admin extends User
{
    // -------------------------------Constructors---------------------------------------
    private function __construct() {}

    public static function fetchAdminFromDb(string $regNo)
    {
        $admin = new Admin();
        $table = $admin->getUserData($regNo);

        $admin->regNo = $table['reg_no'];
        $admin->firstName = $table['first_name'];
        $admin->lastName = $table['last_name'];
        $admin->email = $table['email'];
        $admin->personalEmail = $table['personal_email'];
        $admin->contactNo = $table['contact_no'];
        $admin->lastLogin = $table['last_login'];
        $admin->lastLogout = $table['last_logout'];
        $admin->activeStatus = $table['active_status'];
        $admin->profilePicture = $table['profile_picture'];

        return $admin;
    }
    // --------------------------------------------------------------------------------



    // ---------------------------Getters and Setters-----------------------------------
    public function insert()
    {
        Application::$db->insert(
            table: 'Admin',
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
                'password' => password_hash($this->regNo, PASSWORD_DEFAULT)
            ]
        );
    }
    // --------------------------------------------------------------------------------
}