<?php

namespace app\model;

use app\core\Application;

class Performance
{
    private string $recordDate;
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
        return $performance;
    }

    public static function splitData($performanceData){
        $performance = [        'recordDate' => [],
            'cpuUsage' => [],
            'totalMemory' => [],
            'usedMemory' => [],
            'unusedMemory' => [],
            'processCount' => [],
            'processRunning' => [],
            'processSleeping' => []
        ];
        foreach ($performanceData as $performanceRecord){
            $date = explode(' ', $performanceRecord->getRecordDate());
            $performance['recordDate'][] = substr($date[1], 0, 5);
            $performance['cpuUsage'][] = $performanceRecord->getCpuUsage();
            $performance['totalMemory'][] = $performanceRecord->getTotalMemory();
            $performance['usedMemory'][] = $performanceRecord->getUsedMemory();
            $performance['unusedMemory'][] = $performanceRecord->getUnusedMemory();
            $performance['processCount'][] = $performanceRecord->getProcessCount();
            $performance['processRunning'][] = $performanceRecord->getProcessRunning();
            $performance['processSleeping'][] = $performanceRecord->getProcessSleeping();
        }
        return $performance;
    }

    /**
     * @return string
     */
    public function getRecordDate(): string
    {
        return $this->recordDate;
    }

    /**
     * @return int
     */
    public function getCpuUsage(): int
    {
        return $this->cpuUsage;
    }

    /**
     * @return int
     */
    public function getTotalMemory(): int
    {
        return $this->totalMemory;
    }

    /**
     * @return int
     */
    public function getUsedMemory(): int
    {
        return $this->usedMemory;
    }

    /**
     * @return int
     */
    public function getUnusedMemory(): int
    {
        return $this->unusedMemory;
    }

    /**
     * @return int
     */
    public function getProcessCount(): int
    {
        return $this->processCount;
    }

    /**
     * @return int
     */
    public function getProcessRunning(): int
    {
        return $this->processRunning;
    }

    /**
     * @return int
     */
    public function getProcessSleeping(): int
    {
        return $this->processSleeping;
    }
}