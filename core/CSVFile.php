<?php

namespace app\core;

use app\model\Course;
use app\model\User\Student;

class CSVFile
{
    private string $filename;
    private string $filepath;
    private string $filetype;
    private const csvMimes = [
        'text/x-comma-separated-values', 'text/comma-separated-values',
        'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv',
        'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'
    ];

    /**
     * @description Read the CSV file
     * two functionalities wrapped into this function.
     *  1. Read user account creation csv upload
     *       Read the csv and unwrapped the columns' data. This will categorize data into valid, update and invalid
     *       data. Update array contains the students who are existing in the database, invalid array contains students
     *       index numbers which students have incorrect data (one or more attributes of the student is invalid).
     * @param null $constructor constructor of the account creation object. [class, 'constructor of factory pattern']
     *                  example : [Student::class, 'createNewStudent'];
     *  2. Update Student attendance.
     * @param bool $readUserData true (this will enable read user data function)
     *       This will read attendance containing csv file. Will return false if course codes provided are wrong.
     *       This will update student update for each course as specified in the csv file. 10 points will be given for
     *       leaderboard ranking.
     * @param bool $updateAttendance true (This should be true if want to enable this feature).
     * @param string|null $location
     * @return array|bool
     */
    public function readCSV($constructor = null, bool $readUserData = false,
                            bool $updateAttendance = false, string $location = null): bool|array
    {
        $output = null;
        if (!empty($this->filename) && in_array($this->filetype, self::csvMimes)) {
            if (is_uploaded_file($this->filepath)) {
                $csvFile = fopen($this->filepath, 'r');
                if ($readUserData) {
                    $output = $this->readUserData($constructor, $csvFile);
                } else if ($updateAttendance){
                    $output = $this->updateAttendance($csvFile);
                }
                fclose($csvFile);
                // Save the file in the server
                if ($location != null) {
                    if ($readUserData) { // User account creation file naming
                        if (count($output['invalid']) > 0) {
                            $location = $location . '_invalid.csv';
                        } elseif (count($output['update']) > 0) {
                            $location = $location . '_update.csv';
                        } else {
                            $location = $location . '_valid.csv';
                        }
                    } elseif ($updateAttendance) { // Student attendance file naming
                        if (count($output) > 0) {
                            $location = $location . '_invalid.csv';
                        } else {
                            $location = $location . '_valid.csv';
                        }
                    }
                    move_uploaded_file($this->filepath, $location);
                }
            } else {
                return false;
            }
        }
        return $output;
    }


    public function __construct($file)
    {
        $this->filename = $file['name'];
        $this->filepath = $file['tmp_name'];
        $this->filetype = $file['type'];
    }


    /**
     * @description Create user accounts. This function must be used inside readCSV. This is a passive function.
     * i.e. function itself can not run.
     * @param $csvFile: csvFile which was read by inbuilt fopen(). This is used in readCSV file function.
     * @param $constructor: constructor of the account creation object. [class, 'constructor of factory pattern']
     *            example : [Student::class, 'createNewStudent'];
     * @return bool|array
     */
    public function readUserData($constructor, $csvFile): array
    {
        $valid = [];
        $invalid = [];
        $update = [];
        $header = fgetcsv($csvFile); # contains the column names

        while (($line = fgetcsv($csvFile)) !== FALSE) {
            $unwrappedData = User::unwrapData($line);
            if (User::validateUserAttrFromArray($unwrappedData)) {
                $newUser = call_user_func($constructor, $unwrappedData);
                if (!User::userExists($newUser->getRegNo())) {
                    $valid[] = $newUser;
                } else {
                    $update[] = $newUser;
                }
            } else {
                $invalid[] = $line[0]; // regNo
            }
        }
        return ['valid' => $valid, 'invalid' => $invalid, 'update' => $update];
    }


    /**
     * @description Update student attendance. This function must be used inside readCSV. This is a passive function.
     * i.e. function itself can not run.
     * @param $csvFile : csvFile which was read by inbuilt fopen(). This is used in readCSV file function.
     * @return array
     */
    public function updateAttendance($csvFile): array
    {
        $invalid = [];
        $header = fgetcsv($csvFile); # contains the column names
        array_shift($header); # Header first element is "Index". So, remove it.
        for ($i = 0; $i < count($header); $i++) {
            $header[$i] = trim($header[$i]);
            if (!Course::checkExists($header[$i])) {
                return [$header[$i]];
            }
        }
        while (($line = fgetcsv($csvFile)) !== false) {
            # [2020/cs/0001, 0, 1, 0, 0, 0, 1, 1, 1]
            $regNo = trim(array_shift($line));
            if (User::userExists($regNo)) {
                $student = Student::fetchStuFromDb($regNo);
                $student->updateAllCoursesAttendance($header, $line);
            } else {
                $invalid[] = $regNo;
            }
        }
        return $invalid;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @return string
     */
    public function getFiletype(): string
    {
        return $this->filetype;
    }
}