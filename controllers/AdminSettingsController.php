<?php

namespace app\controllers;

use app\core\AdminConfiguration;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\model\Course;
use app\model\CourseAnnouncement;
use app\model\CourseSubTopic;
use app\model\Submission;
use app\model\User\Lecturer;
use app\model\User\Student;
use DateTime;

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

    public function coordinatorOptions(Request $request)
    {
        $body = $request->getBody();
        $msg = "";
        $is_coordinator_updated = false;

        if (isset($body['assign'])) { // Assign coordinator
            $is_coordinator_updated = Lecturer::assignCoordinator(
                regNo: explode("-", $body['lecturer_regno_name'])[0],
                degreeProgramCode: $body['degree_program'] . " " . $body['batch_year']
            );

            if ($is_coordinator_updated) {
                $msg = "Coordinator assigned successfully";
            } else {
                $msg = "Error assigning coordinator. Please try again later.";
            }
        } else if (isset($body['remove'])) { // remove coordinator
            $is_coordinator_updated = Lecturer::removeCoordinator(
                regNo: explode("-", $body['lecturer_regno_name'])[0]);

            if ($is_coordinator_updated) {
                $msg = "Coordinator removed successfully";
            } else {
                $msg = "Error removing coordinator. Please try again later.";
            }
        }

        $params = $this->getParameters();
        $params['msg'] = $msg;
        $params['is_coordinator_updated'] = $is_coordinator_updated;

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


    public function startNewSemester(Request $request)
    {
        CourseAnnouncement::truncateCourseAnnouncements();
        Course::truncateStuCourses();
        Submission::truncateStuCourseSubmissioms();
        CourseSubTopic::truncateStuCourseSubTopics();

        $params = $this->getParameters();
        $params['msg'] = "New semester started successfully";
        $params['is_semester_started'] = true;

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

        $coordinators = Lecturer::fetchCoordinators();
        $isSemesterEnd =  !(new DateTime() > new DateTime(Application::$admin_config->getSemEndDate())
        and new DateTime() < new DateTime(Application::$admin_config->getSemStartDate()));

        return [
            // config file/ object params
            'batch_years' => Student::getBatchYears($regNos),
            'degree_programs' => Student::getDegreePrograms($degreePrograms),
            'sem_start' => Application::$admin_config->getSemStartDate(),
            'sem_end' => Application::$admin_config->getSemEndDate(),
            'sem_count_year' => Application::$admin_config->getSemCountYear(),
            // other params
            'lecturers' => Lecturer::fetchLecturers(),
            'coordinatorRegNos' => $coordinators['reg_no'],
            'coordinatorDegreeCode' => $coordinators['degree_program_code'],
            'isSemesterEnd' => $isSemesterEnd,
        ];
    }
}