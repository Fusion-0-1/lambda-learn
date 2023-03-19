<?php

namespace app\controllers;

use app\core\Controller;
use app\core\CSVFile;
use app\core\Request;
use app\core\User;
use app\model\User\Admin;
use app\model\User\Lecturer;
use app\model\User\Student;
use app\model\Course;

class ProfileController extends Controller
{
    public function displayProfile()
    {
        $profile = unserialize($_SESSION['user']);
        $params = ['user'=>$profile];
        if($_SESSION['user-role'] == 'Admin'){
            return $this->render(
                view: 'admin_profile',
                params: $params
            );
        }
        $params['courses'] = Course::getUserCourses($profile);
        return $this->render(
            view: 'profile',
            params: $params
        );
    }

    public function editProfile(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $regNo = $user->getRegNo();
        $params['mssg'] = 'ERROR';
//        var_dump($params['mssg']);

        // Update password
        if(isset($body['password'])){
            $newPassword = $body['new_password'];
            $confirmPassword = $body['confirm_password'];
            if (User::authenticateUser($regNo, $body['password']) and
                $newPassword == $confirmPassword)
            {
                $user->updatePassword($newPassword);
                $params['mssg'] = 'Password';
            }
        // Edit profile
        } else {
            $userRegNo = str_replace('/', '', $user->getRegNo());
            $fileName = $_FILES['profile_picture']['name'];
            $fileTmpName = $_FILES['profile_picture']['tmp_name'];
            if($fileName)
            {
                $fileExtension = strtolower(explode('.', $fileName)[1]);
                $fileNameNew = $userRegNo . "." . $fileExtension;
                $filePath = 'images/profile/' . $fileNameNew;

                //Remove previous profile images if exists
                $wildcardPath = 'images/profile/' . $userRegNo . '.*';
                array_map('unlink', glob($wildcardPath));

                move_uploaded_file($fileTmpName, $filePath);
                $user->setProfilePicture($filePath);

                $_SESSION['user'] = serialize($user);
                $params['mssg'] = 'Profile picture';
            }
            if(User::validateContactNo($body['contact']) and User::validateEmail($body['personal_email'])){
                $user->setContactNo($body['contact']);
                $user->setPersonalEmail($body['personal_email']);
                $params['mssg'] = 'Profile';
            }
            $user->updateProfile();
        }

        $params['user'] = $user;
        if($_SESSION['user-role'] == 'Admin'){
            return $this->render(
                view: 'admin_profile',
                allowedRoles: ['Admin'],
                params: $params
            );
        }
        $params['courses'] = Course::getUserCourses($user);
        return $this->render(
            view: 'profile',
            allowedRoles: ['Student', 'Lecturer', 'Coordinator'],
            params: $params
        );
    }


    public function displayAccountCreation(Request $request)
    {
        $body = $request->getBody();
        return $this->render(
            view: '/account_creation',
            allowedRoles: ['Admin'],
            params: $body
        );
    }

    // POST request
    public function uploadCSV(Request $request)
    {
        $file = new CSVFile($request->getFile());
        $body = $request->getBody();
        $type = $body['type'];
        $readCSVParams = [];
        if ($type == 'Student') {
            $readCSVParams = [Student::class, 'createNewStudent'];
        } elseif ($type == 'Lecturer') {
            $readCSVParams = [Lecturer::class, 'createNewLecturer'];
        } elseif ($type == 'Admin') {
            $readCSVParams = [Admin::class, 'createNewAdmin'];
        }

        $location = '../CSV Files/User Uploads/Profiles/' . date('Y-m-d H:i:s');

        $categorizedData = $file->readCSV(
            constructor: $readCSVParams,
            readUserData: true,
            location: $location
        );
        if ($categorizedData != false) {
            if (count($categorizedData['update']) > 0 or count($categorizedData['invalid']) > 0) {
                return $this->render(
                    view: 'account_creation',
                    allowedRoles: ['Admin'],
                    params: [
                        'updatedUsers' => $categorizedData['update'],
                        'invalidUsersRegNo' => $categorizedData['invalid'],
                        'type' => $type
                    ]
                );
            }
            foreach ($categorizedData['valid'] as $user) {
                $user->insert();
            }
        }
        $body['success_mssg'] = true;
        return $this->render(
            view: 'account_creation',
            allowedRoles: ['Admin'],
            params: $body
        );
    }
}