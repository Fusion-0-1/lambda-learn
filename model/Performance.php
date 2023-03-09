<?php

namespace app\model;

class Performance
{
    private int $recordDate;
    private int $cpuUsage;
    private int $totalMemory;
    private int $usedMemory;
    private int $unusedMemory;
    private int $processCount;
    private int $processRunning;
    private int $processSleeping;

    private function __construct() {}

    public static function createNewPerformance(
        $recordDate, $cpuUsage, $totalMemory, $usedMemory, $unusedMemory,
        $processCount, $processRunning, $processSleeping) {

        $performance = new Performance();
        $performance->recordDate = $recordDate;
        $performance->cpuUsage = $cpuUsage;
        $performance->totalMemory = $totalMemory;
        $performance->usedMemory = $usedMemory;
        $performance->unusedMemory = $unusedMemory;
        $performance->processCount = $processCount;
        $performance->processRunning = $processRunning;
        $performance->processSleeping = $processSleeping;

        return $performance;
    }

    public static function getPerformance($limit = 100): array
    {
        $performance = [];
        $results = Application::$db->select(
            table: 'PerformanceHistory',
            order: 'record_date DESC',
            limit: $limit
        );
        while ($sub = Application::$db->fetch($results)){
            $performance[] = self::createNewPerformance(
                $sub['record_date'],
                $sub['cpu_usage'],
                $sub['total_memory'],
                $sub['used_memory'],
                $sub['unused_memory'],
                $sub['process_count'],
                $sub['process_running'],
                $sub['process_sleeping'],
            );
        }
        var_dump($performance);
        return $performance;
    }

    public static function splitData($performanceData){
        $performance = [];
        foreach ($performanceData as $performance){
            $performance['recordDate'] += $performance->recordDate;
            $performance['cpuUsage'] += $performance->cpuUsage;
            $performance['totalMemory'] += $performance->totalMemory;
            $performance['usedMemory'] += $performance->usedMemory;
            $performance['unusedMemory'] += $performance->unusedMemory;
            $performance['processCount'] += $performance->processCount;
            $performance['processRunning'] += $performance->processRunning;
            $performance['processSleeping'] += $performance->processSleeping;
        }
        return $performance;
    }
}