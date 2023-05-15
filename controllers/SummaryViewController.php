<?php

namespace app\controllers;

use app\core\Controller;
use app\model\Course;
use app\model\Performance;

class SummaryViewController extends Controller
{
    /**
     * @description Display coordinator charts
     * @return array|false|string|string[]
     */
    public function displayCoordinatorCharts()
    {
        $user = unserialize($_SESSION['user']);
        $courses = Course::getUserCourses($user);

        $courseCodes = [];
        $progress = [];
        foreach ($courses as $course) {
            $courseCodes[] = $course->getCourseCode();
            $progress[] = $course->getLecTotalTopicCompletionProgress();
        }
        return $this->render(
            view: '/attendance_course_progress',
            allowedRoles: ['Coordinator'],
            params: [
                'courseCodes' => $courseCodes,
                'progress' => $progress
            ]
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