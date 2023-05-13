<?php

namespace app\controllers;

use app\core\AdminConfiguration;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\model\User\Lecturer;
use app\model\User\Student;

class AdminSettingsController extends Controller
{
    public function displayAdminSettings(Request $request)
    {
        return $this->render(
            view: 'admin_settings',
            allowedRoles: ['Admin'],
            params: $this->getParameters()
        );
    }

    public function assignCoordinator(Request $request)
    {
        $body = $request->getBody();
        $is_assigned_coordinator = Lecturer::assignCoordinator(
            regNo: explode("-", $body['lecturer_regno_name'])[0],
            degreeProgramCode: $body['degree_program'] . " " . $body['batch_year']
        );

        $params = $this->getParameters();
        $params['is_assigned_coordinator'] = $is_assigned_coordinator;

        if ($is_assigned_coordinator) {
            $params['msg'] = "Coordinator assigned successfully";
        } else {
            $params['msg'] = "Error assigning coordinator. Please try again later.";
        }

        return $this->render(
            view: 'admin_settings',
            allowedRoles: ['Admin'],
            params: $params
        );
    }

    public function updateAcademicSettings(Request $request)
    {
        $body = $request->getBody();
        $config = [
            [
                'sem_start_date' => $body['sem_start_date'],
                'sem_end_date' => $body['sem_end_date'],
                'sem_count_year' => $body['sem_count_year'],
            ]
        ];
        $is_settings_setup = Application::$admin_config->updateAcademicSettings($config);

        $params = $this->getParameters();
        $params['is_settings_setup'] = $is_settings_setup;

        if ($is_settings_setup) {
            $params['msg'] = "Academic settings updated successfully";
        } else {
            $params['msg'] = "Error updating academic settings. Please try again later.";
        }

        return $this->render(
            view: 'admin_settings',
            allowedRoles: ['Admin'],
            params: $params
        );
    }

    private function getParameters(): array {
        $users = Student::fetchStudents();

        $regNos = [];
        $degreePrograms = [];
        foreach ($users as $user) {
            $regNos[] = $user["reg_no"];
            $degreePrograms[] = $user['degree_program_code'];
        }

        return [
            'batch_years' => Student::getBatchYears($regNos),
            'degree_programs' => Student::getDegreePrograms($degreePrograms),
            'sem_start' => Application::$admin_config->getSemStartDate(),
            'sem_end' => Application::$admin_config->getSemEndDate(),
            'sem_count_year' => Application::$admin_config->getSemCountYear(),
            'lecturers' => Lecturer::fetchLecturers(),
        ];
    }
}