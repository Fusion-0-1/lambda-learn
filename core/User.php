<?php

namespace app\core;

use app\model\User\Student;

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
        $result = Application::$db->select(
            table: $userType=='Lecturer'? 'AcademicStaff': $userType,
            where: ['reg_no'=>$regNo],
            limit: 1
        );
        $table = Application::$db->fetch($result);
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
            columns: ['password'],
            where: ['reg_no'=>$regNo]
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

    public static function userExists($regNo): bool
    {
        return Application::$db->checkExists(
            table: self::getUserTable($regNo),
            primaryKey: ['reg_no'=>$regNo]
        );
    }

    public function updateProfile():void
    {
        $userData = [
            'personal_email' => $this->personalEmail,
            'contact_no' => $this->contactNo,
            'profile_picture' => $this->profilePicture
        ];

        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: $userData,
            where: ['reg_no'=>$this->regNo]
        );
    }

    public function updatePassword($newPassword){
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        Application::$db->update(
            table: self::getUserTable($this->regNo),
            columns: ['password' => $hashedPassword],
            where: ['reg_no' => $this->regNo]
        );
    }


    /**
     * @param array $line: array of strings
     * !IMPORTANT: follow the order of the keys as in the code when passing as an associative array.
     * @return array : array of User objects
     * @description : unwrap csv file line. Break into an associative array.
     */
    public static function unwrapData(array $line): array
    {
        return [
            'regNo' =>trim($line[0]),
            'firstName' => trim($line[1]),
            'lastName' => trim($line[2]),
            'email' => trim($line[3]),
            'personalEmail' => trim($line[4]),
            'contactNo' => trim($line[5])
        ];
    }


    /**
     * @param int $length: length of the password
     * @return string: random password
     * @description: generate a random password
     */
    protected function generateRandomPassword(int $length = 8) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    // --------------------------------------------------------------------------------



    // ---------------------------Abstract Methods-----------------------------------
    public abstract function insert();
    // --------------------------------------------------------------------------------



    // -------------------------Field validation methods---------------------------------
    public static function validateName($name): bool
    {
        /*
         * ^: This matches the start of the string.
         * [a-zA-Z]: This matches any character from a to z and A to Z.
         * *: preceding character can be matched any number of times, including zero.
         * $: This matches the end of the string.
         */
        return preg_match("/^[a-zA-Z-' ]*$/",$name);
    }

    public static function validateEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateRegNo($regNo): bool
    {
        /*
         *  ^: This matches the start of the string.
         *  \d{4}: Matches any four digits at the start of the string.
         *  \/: This matches a forward slash.
         *  .*: This matches any number of any characters (except a newline) after the first forward slash. This is the part of the string that should contain the middle section of the pattern.
         *  \/: This matches a second forward slash.
         *  \d{4}: This matches any four digits at the end of the string.
         *  $: This matches the end of the string.
         */
        return preg_match("/^\d{4}\/.*\/\d{4}$/", $regNo);
    }

    public static function validateContactNo($contactNo): bool
    {
        /*
         * Local numbers: 0xxxxxxxxx
         * ^: This matches the start of the string.
         * \d{10}: d matches a digit (equivalent to [0-9]). {10} matches the previous token exactly 11 times
         * $: This matches the end of the string.
         */
        if (preg_match('/^\d{10}$/', $contactNo)) {
            return true;
        }
        /*
         * International numbers: +94xxxxxxxxx
         * ^: This matches the start of the string.
         * \+: This matches a plus sign, which is typically the first character in a phone number with a country code.
         * \d{11}: d matches a digit (equivalent to [0-9]). {11} matches the previous token exactly 11 times
         * $: This matches the end of the string.
         */
        else if (preg_match('/^\+\d{11}$/', $contactNo)) {
            return true;
        }
        return false;
    }

    public static function validateUserAttributes(
        $regNo, $firstName, $lastName, $email, $contactNo, $personalEmail=null
    ): bool
    {
        if(
            // Not null checks
            strlen($regNo) == 12 && # 20xx/cs/xxxx
            $firstName !=  '' && $lastName != '' &&
            $email != ''
        ) {
            if (!self::validateName($firstName . $lastName)) {
                return false;
            }
            if (!self::validateEmail($email)) {
                return false;
            }
            if (!self::validateRegNo($regNo)) {
                return false;
            }
        } else {
            return false;
        }
        if ($contactNo != '') {
            if (!self::validateContactNo($contactNo)) {
                return false;
            }
        }
        if ($personalEmail != '') {
            if (!self::validateEmail($personalEmail)) {
                return false;
            }
        }

        return true;
    }

    public static function validateUserAttrFromArray(array $data): bool
    {
        return self::validateUserAttributes(
            $data['regNo'], $data['firstName'], $data['lastName'],
            $data['email'], $data['contactNo'], $data['personalEmail']
        );
    }
    // --------------------------------------------------------------------------------



    // ---------------------------Getters and Setters-----------------------------------
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
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
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
    // --------------------------------------------------------------------------------

}