<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class ReportController extends Controller
{
    public function displayUtilizationReport()
    {
        return $this->render(
            view: '/utilization',
            allowedRoles: ['Admin']
        );
    }

    public function uploadAttendance(Request $request){
        if ($request->isGet()){
            return $this->render(
                view: '/attendance_upload',
                allowedRoles: ['Admin']
            );
        }
    }
}