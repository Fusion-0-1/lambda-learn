<?php

namespace app\controllers;

use app\core\Controller;
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
    public function uploadCSV()
    {
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                fgetcsv($csvFile);
                while (($line = fgetcsv($csvFile)) !== FALSE) {
                    if (Student::validateUserAttributes(
                        $line[0], // regNo
                        $line[1], // firstName
                        $line[2], // lastName
                        $line[3], // email
                        $line[4], // contactNo
                        $line[5], // indexNo
                        $line[6]  // degreeProgramCode
                    )) {
                        # TODO: check if student already exists in the database
                        #       else insert
                    }
                }
                fclose($csvFile);
                $qstring = '?status=succ';
            } else {
                $qstring = '?status=err';
            }
        } else {
            $qstring = '?status=invalid_file';
        }
    }
}