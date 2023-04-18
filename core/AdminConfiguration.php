<?php

namespace app\core;

class AdminConfiguration
{
    private string $sem_start_date;
    private string $sem_end_date;
    private int $sem_count;
    private int $max_sem_count;

    public function __construct(array $config)
    {
        foreach ($config as $setting){
            foreach ($setting as $key => $value) {
                $this->{$key} = $value;
            }
        }
        var_dump($this);
    }

    /**
     * @return string
     */
    public function getSemStartDate(): string
    {
        return $this->sem_start_date;
    }

    /**
     * @param string $sem_start_date
     */
    public function setSemStartDate(string $sem_start_date): void
    {
        $this->sem_start_date = $sem_start_date;
    }

    /**
     * @return string
     */
    public function getSemEndDate(): string
    {
        return $this->sem_end_date;
    }

    /**
     * @param string $sem_end_date
     */
    public function setSemEndDate(string $sem_end_date): void
    {
        $this->sem_end_date = $sem_end_date;
    }

    /**
     * @return int
     */
    public function getSemCount(): int
    {
        return $this->sem_count;
    }

    /**
     * @param int $sem_count
     */
    public function setSemCount(int $sem_count): void
    {
        $this->sem_count = $sem_count;
    }

    /**
     * @return int
     */
    public function getMaxSemCount(): int
    {
        return $this->max_sem_count;
    }

    /**
     * @param int $max_sem_count
     */
    public function setMaxSemCount(int $max_sem_count): void
    {
        $this->max_sem_count = $max_sem_count;
    }
}