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

    public static function createNewAdmin($data)
    {
        $admin = new Admin();
        $admin->regNo = $data['regNo'];
        $admin->firstName = $data['firstName'];
        $admin->lastName = $data['lastName'];
        $admin->email = $data['email'];
        $admin->personalEmail = $data['personalEmail'];
        $admin->contactNo = $data['contactNo'];

        return $admin;
    }
    // --------------------------------------------------------------------------------



    // ---------------------------Getters and Setters-----------------------------------
    /**
     * @description Insert new admin to database
     * @return string
     */
    public function insert(): string
    {
        $password = $this->generateRandomPassword();
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
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]
        );
        return $password;
    }
    // --------------------------------------------------------------------------------

    /**
     * @description Get admin name from database according to reg_no
     * @param string $regNo
     * @return string
     */
    public static function getAdminName(string $regNo)
    {
        $results = Application::$db->select(
            table: 'Admin',
            columns: ['first_name', 'last_name'],
            where: ['reg_no' => $regNo]
        );
        $row = Application::$db->fetch($results);
        return $row['first_name'] . ' ' . $row['last_name'];
    }
}