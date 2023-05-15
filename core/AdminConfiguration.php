<?php

namespace app\core;

class AdminConfiguration
{
    private string $sem_start_date;
    private string $sem_end_date;
    private int $sem_count_year;

    public function __construct(array $config)
    {
        foreach ($config as $setting){
            foreach ($setting as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function updateAcademicSettings(array $config)
    {
        // update object variables
        foreach ($config as $setting){
            foreach ($setting as $key => $value) {
                $this->{$key} = $value;
            }
        }
        // save in configuration file. admin_configuration.ini
        $data = [
            'semester' => [
                'sem_start_date' => $this->sem_start_date,
                'sem_end_date' => $this->sem_end_date,
                'sem_count_year' => $this->sem_count_year,
            ]
        ];

        $iniString = '';
        foreach ($data as $section => $values) {
            $iniString .= "[$section]\n";
            foreach ($values as $key => $value) {
                $iniString .= "$key=$value\n";
            }
            $iniString .= "\n";
        }

        file_put_contents('../admin_configuration.ini', $iniString);

        return true;
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
    public function getSemCountYear(): int
    {
        return $this->sem_count_year;
    }

    /**
     * @param int $sem_count_year
     */
    public function setSemCountYear(int $sem_count_year): void
    {
        $this->sem_count_year = $sem_count_year;
    }
}