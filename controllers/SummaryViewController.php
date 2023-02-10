<?php

namespace app\controllers;

use app\core\Controller;

class SummaryViewController extends Controller
{
    public function displayCoordinatorCharts()
    {
        return $this->render(
            view: '/attendance_course_progress',
            allowedRoles: ['Coordinator']
        );
    }
}