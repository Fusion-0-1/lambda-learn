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
        $courses = Course::getUserCourses($profile->getRegNo());
        return $this->render('profile', ['user'=>$profile, 'courses'=>$courses]);

    }

    public function editProfile(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $user->setContactNo($body['contact']);
        $user->setPersonalEmail($body['personal_email']);
        $user->editProfile();
        $courses = Course::getUserCourses($user->getRegNo());
        return $this->render('profile', ['user'=>$user, 'courses'=>$courses]);
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