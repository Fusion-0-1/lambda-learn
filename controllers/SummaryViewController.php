<?php

namespace app\controllers;

use app\core\Controller;
use app\model\Performance;

class SummaryViewController extends Controller
{
    /**
     * @description Display coordinator charts
     * @return array|false|string|string[]
     */
    public function displayCoordinatorCharts()
    {
        return $this->render(
            view: '/attendance_course_progress',
            allowedRoles: ['Coordinator']
        );
    }

    /**
     * @description Display utilization charts
     * @return array|false|string|string[]
     */
    public function displayUtilizationReport()
    {
        $performanceData = Performance::getPerformance();
        $performanceData = Performance::splitData($performanceData);
        return $this->render(
            view: '/utilization',
            allowedRoles: ['Admin'],
            params: [
                'performanceData' => $performanceData
            ]
        );
    }
}