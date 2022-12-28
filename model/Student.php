<?php

namespace app\model;

use app\core\Application;
use app\core\User;

class Student extends User
{
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

    // -------------------------Field validation methods---------------------------------
    public static function validateUserAttributes($regNo, $firstName, $lastName, $email, $contactNo,
                                                  $indexNo=null, $degreeProgramCode=null): bool
    {
        if(
            // Not null checks
            strlen($indexNo) == 10 &&
            $degreeProgramCode != ''
        ) {
            /*
             * ^: This matches the start of the string.
             * \d{10}: This matches 10 consecutive digits. This is the part of the pattern that ensures that the string contains exactly 10 digits.
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

    public static function validateIndexNo($indexNo): bool
    {
        /*
         * ^: This matches the start of the string.
         * \d{10}: This matches 10 consecutive digits. This is the part of the pattern that ensures that the string contains exactly 10 digits.
         * $: This matches the end of the string.
         */
        return preg_match("/^\d{10}$/", $indexNo);
    }
    // --------------------------------------------------------------------------------

    public function flatten(): array
    {
        $array = parent::flatten();
        $array['indexNo'] = $this->indexNo;
        $array['dateJoined'] = $this->dateJoined;
        $array['degreeProgramCode'] = $this->degreeProgramCode;
        return $array;
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

}