<?php

namespace app\core;

abstract class User
{
    protected function getUserData($regNo): array
    {
        // TODO: Catch Invalid user type error thrown by getUserType()
        // TODO: Create a view without password field
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

    public static function authenticateUser($regNo, $password): bool
    {
        // TODO: Catch Invalid user type error thrown by getUserType()
        $userType = self::getUserType($regNo);
        $table = Application::$db->select(
            table: $userType=='Lecturer'? 'AcademicStaff': $userType,
            columns: 'password',
            where: ['reg_no'=>$regNo],
            limit: 1
        );

        return password_verify($password, $table['password']);
    }
}