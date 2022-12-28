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

    public function editProfile():void
    {
        $userData = [
            'personal_email'=>$this->personalEmail,
            'contact_no'=>$this->contactNo
        ];

        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: $userData,
            where: ['reg_no'=>$this->regNo]
        );
    }

    /**
     * @return string
     */
    public function getRegNo(): string
    {
        return $this->regNo;
    }

    /**
     * @param string $regNo
     */
    public function setRegNo(string $regNo): void
    {
        $this->regNo = $regNo;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPersonalEmail(): string
    {
        return $this->personalEmail;
    }

    /**
     * @param string $personalEmail
     */
    public function setPersonalEmail(string $personalEmail): void
    {
        $this->personalEmail = $personalEmail;
    }

    /**
     * @return string
     */
    public function getContactNo(): string
    {
        return $this->contactNo;
    }

    /**
     * @param string $contactNo
     */
    public function setContactNo(string $contactNo): void
    {
        $this->contactNo = $contactNo;
    }

    /**
     * @return string
     */
    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    /**
     * @param string $lastLogin
     */
    public function setLastLogin(string $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return string
     */
    public function getLastLogout(): string
    {
        return $this->lastLogout;
    }

    /**
     * @param string $lastLogout
     */
    public function setLastLogout(string $lastLogout): void
    {
        $this->lastLogout = $lastLogout;
    }

    /**
     * @return bool
     */
    public function isActiveStatus(): bool
    {
        return $this->activeStatus;
    }

    /**
     * @param bool $activeStatus
     */
    public function setActiveStatus(bool $activeStatus): void
    {
        $this->activeStatus = $activeStatus;
    }

    /**
     * @return string
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

}