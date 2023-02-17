<?php

namespace app\controllers;

use app\core\Controller;
use app\core\CSVFile;
use app\core\Request;
use app\model\User\Student;
use app\model\Course;

class ProfileController extends Controller
{
    public function displayProfile()
    {
        $profile = unserialize($_SESSION['user']);

        if($_SESSION['user-role'] !== 'Admin'){
            $courses = Course::getUserCourses($profile);
            return $this->render(
                view: 'profile',
                params: ['user'=>$profile, 'courses'=>$courses]
            );
        }
        else{
            return $this->render(
                view: 'profile',
                params: ['user'=>$profile]
            );
        }
    }

    public function editProfile(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);

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
        }

        $user->setContactNo($body['contact']);
        $user->setPersonalEmail($body['personal_email']);

        $user->editProfile();
        return $this->render(
            view: 'profile',
            params: [
                'user'=>$user,
                'courses'=>Course::getUserCourses($user)
            ]
        );
    }


    public function displayAccountCreation()
    {
        return $this->render(
            view: '/account_creation',
            allowedRoles: ['Admin']
        );
    }

    // POST request
    public function uploadCSV(Request $request)
    {
        $file = new CSVFile($request->getFile());
        $catergorizedData = $file->readUserCSV([Student::class, 'createNewStudent']);

        if ($catergorizedData != false) {
            foreach ($catergorizedData['valid'] as $student) {
                $student->insert();
            }
            if (count($catergorizedData['update']) > 0 or count($catergorizedData['invalid']) > 0) {
                return $this->render(
                    'account_creation',
                    [
                        'updatedUsers' => $catergorizedData['update'],
                        'invalidUsersRegNo' => $catergorizedData['invalid']
                    ]
                );
            }
        }
        header("Location: /account_creation");
    }
}