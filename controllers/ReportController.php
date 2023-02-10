<?php

namespace app\controllers;

use app\core\Controller;

class ReportController extends Controller
{
    public function displayUtilizationReport()
    {
        return $this->render(
            view: '/utilization',
            allowedRoles: ['Admin']
        );
    }
}