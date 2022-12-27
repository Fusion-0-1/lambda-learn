<?php

namespace app\core;

abstract class User
{
    protected string $regNo;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $personalEmail;
    protected string $contactNo;
    protected string $lastLogin;
    protected string $lastLogout;
    protected bool $activeStatus;
    protected string $profilePicture;

    protected function getUserData($regNo): array
    {
        $userType = self::getUserType($regNo);
        $table = Application::$db->select(
            table: $userType=='Lecturer'? 'AcademicStaff': $userType,
            where: ['reg_no'=>$regNo],
            limit: 1
        );
        return Application::$db->setEmptyToNullColumns($table);
    }

    public static function getUserType(string $regNo)
    {
        // 20xx/cs/xxxx - Students
        // 20xx/is/xxxx - Students
        // 20xx/lc/xxxx - Lecturer
        // 20xx/ad/xxxx - Admin
        $type = strtolower(explode('/', $regNo, 3)[1] ?? 'ERROR');
        if ($type == 'cs' || $type == 'is') {
            return 'Student';
        } else if ($type == 'lc') {
            return 'Lecturer';
        } else if ($type == 'ad') {
            return 'Admin';
        }
        return false;
    }

    private static function getUserTable($regNo): string
    {
        $userType = self::getUserType($regNo);
        return $userType=='Lecturer'? 'AcademicStaff': $userType;
    }

    public static function authenticateUser($regNo, $password): bool
    {
        $result = Application::$db->select(
            table: self::getUserTable($regNo),
            columns: 'password',
            where: ['reg_no'=>$regNo],
            limit: 1,
            getAsArray: false
        );
        if (Application::$db->rowCount($result) == 1) {
            $table = Application::$db->fetch($result);
            return password_verify($password, $table['password']);
        }
        return false;
    }

    public function setLogin($time=null, $activeStatus=1): void
    {
        $time = $time ?? date('Y-m-d H:i:s', time());
        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: ['last_login'=>$time, 'active_status'=>$activeStatus],
            where: ['reg_no'=>$this->regNo]
        );
    }

    public function setLogout($time=null, $activeStatus=0): void
    {
        $time = $time ?? date('Y-m-d H:i:s', time());
        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: ['last_logout'=>$time, 'active_status'=>$activeStatus],
            where: ['reg_no'=>$this->regNo]
        );
    }

    public function editProfile(string $email, string $personalEmail, string $contactNo):void
    {
        $userData = array('email'=>$email,'personal_email'=>$personalEmail, 'contact_no'=>$contactNo);

        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: $userData,
            where: ['reg_no'=>$this->regNo]
        );
    }

    public function flatten(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }
}