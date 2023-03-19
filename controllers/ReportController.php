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
                allowedRoles: ['Admin'],
                params: ['csvFiles' => CSVFile::getAttendanceReports()]
            );
        } elseif ($request->isPost()) {
            $body = $request->getBody();
            $file = new CSVFile($request->getFile());

            $output = $file->readCSV(
                updateAttendance: true,
                location: 'User Uploads/Attendance/' . $file->getFilename() . "_" . $body['date']
            );
            // get files after upload
            $body['csvFiles'] = CSVFile::getAttendanceReports();

            # if csv header course codes are invalid, $output will be a false.
            # if regNo are invalid, invalid regNos will be assigned to $output
            # if all are correct, $output will be an empty array
            if (count($output) > 0) {
                $body['errors'] = $output;
                return $this->render(
                    view: '/attendance_upload',
                    allowedRoles: ['Admin'],
                    params: $body
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