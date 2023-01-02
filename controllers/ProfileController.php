<?php

namespace app\controllers;

use app\core\Controller;
use app\core\CSVFile;
use app\core\Request;
use app\model\Student;

class ProfileController extends Controller
{
    public function displayProfile()
    {
        $profile = unserialize($_SESSION['user']);
        return $this->render('profile', ['user'=>$profile]);
    }

    public function editProfile(Request $request)
    {
        $body = $request->getBody();
        $user = unserialize($_SESSION['user']);
        $user->setContactNo($body['contact']);
        $user->setPersonalEmail($body['personal_email']);
        $user->editProfile();
        return $this->render('profile', ['user'=>$user]);
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