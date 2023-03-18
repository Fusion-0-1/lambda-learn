<?php

namespace app\controllers;

use app\core\Controller;
use app\core\CSVFile;
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

    public function uploadAttendance(Request $request)
    {
        if ($request->isGet()){
            return $this->render(
                view: '/attendance_upload',
                allowedRoles: ['Admin']
            );
        } elseif ($request->isPost()) {
            $file = new CSVFile($request->getFile());
            $output = $file->readCSV(updateAttendance: true);
            # if csv header course codes are invalid, $output will be a false.
            # if regNo are invalid, invalid regNos will be assigned to $output
            # if all are correct, $output will be an empty array
            if ($output != false) {
                return $this->render(
                    view: '/attendance_upload',
                    allowedRoles: ['Admin'],
                    params: ['errors' => $output]
                );
            }
            $body['success_mssg'] = true;
            return $this->render(
                view: '/attendance_upload',
                allowedRoles: ['Admin'],
                params: $body
            );
        }
    }
}