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
        if (!preg_match('/^\d{10}$/', $contactNo)) {
            return false;
        }
        /*
         * International numbers: +94xxxxxxxxx
         * ^: This matches the start of the string.
         * \+: This matches a plus sign, which is typically the first character in a phone number with a country code.
         * \d{11}: d matches a digit (equivalent to [0-9]). {11} matches the previous token exactly 11 times
         * $: This matches the end of the string.
         */
        else if (!preg_match('/^\+\d{11}$/', $contactNo)) {
            return false;
        }
        return true;
    }

    public static function validateUserAttributes($regNo, $firstName, $lastName, $email, $contactNo): bool
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

        return true;
    }
    // --------------------------------------------------------------------------------

    public function flatten(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }
}