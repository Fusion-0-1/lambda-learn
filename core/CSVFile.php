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


    // -------------------------------Constructors---------------------------------------
    public function __construct($file)
    {
        $this->filename = $file['name'];
        $this->filepath = $file['tmp_name'];
        $this->filetype = $file['type'];
    }
    // --------------------------------------------------------------------------------



    // -----------------------------Basic Methods-------------------------------------
    /**
     * @description Retrieve attendance reports details from the database
     * @return array
     */
    public static function getAttendanceReports()
    {
        $csvFiles = [];
        $results = Application::$db->select(
            table: 'AttendanceReport',
            order: 'report_date DESC'
        );
        while ($record = Application::$db->fetch($results)){
            $csvFiles[] = $record;
        }
        return $csvFiles;
    }

    /**
     * @description Insert attendance report details into the database
     * @param $path
     * @param $date
     * @return void
     */
    public function insertAttendanceReport($path, $date): void
    {
        Application::$db->insert(
            table: 'AttendanceReport',
            values: [
                'title' => $this->filename,
                'report_date' => $date,
                'path' => $path
            ]
        );
    }
    // --------------------------------------------------------------------------------



    // ----------------------------Custom Methods--------------------------------------
    /**
     * @description Read the CSV file
     * three functionalities wrapped into this function.
     *  1. Read user account creation csv upload
     *       Read the csv and unwrapped the columns' data. This will categorize data into valid, update and invalid
     *       data. Update array contains the students who are existing in the database, invalid array contains students
     *       index numbers which students have incorrect data (one or more attributes of the student is invalid).
     *      @param null $constructor constructor of the account creation object. [class, 'constructor of factory pattern']
     *                       example : [Student::class, 'createNewStudent'];
     *  2. Update Student attendance.
     *      @param bool $readUserData true (this will enable read user data function)
     *       This will read attendance containing csv file. Will return false if course codes provided are wrong.
     *       This will update student update for each course as specified in the csv file. 10 points will be given for
     *       leaderboard ranking.
     * 3. Assign Students to a course
     *      @param bool $assignStudents (this will enable assign students function)
     *       This will read student registration numbers in the csv file. Will return invalid registration numbers as an array.
     *       This will assign students to the course and the file should be renamed with the course code.
     *  4: Upload Exam Marks
     *       @param bool $uploadExamMarks true (this will enable upload exam marks function)
     *       Reads the CSV file containing exam marks.
     *       Returns an array of valid registration numbers and their corresponding exam marks.
     * @param bool $updateAttendance true (This should be true if want to enable this feature).
     * @param string|null $location
     * @return array|bool|null
     */
    public function readCSV($constructor = null, bool $readUserData = false,
                            bool $updateAttendance = false, bool $assignStudents = false, bool $uploadExamMarks = false, string $location = null)
    {
        $output = null;
        if (!empty($this->filename) && in_array($this->filetype, self::csvMimes)) {
            if (is_uploaded_file($this->filepath)) {
                $csvFile = fopen($this->filepath, 'r');
                if ($readUserData) {
                    $output = $this->readUserData($constructor, $csvFile);
                } else if ($updateAttendance){
                    $output = $this->updateAttendance($csvFile);
                } else if ($assignStudents) {
                    $output = $this->assignStudents($csvFile);
                }
                elseif($uploadExamMarks) {
                    $output = $this->uploadExamMarks($csvFile);
                }
                fclose($csvFile);
                // Save the file in the server
                if ($location != null) {
                    if ($updateAttendance) { // Student attendance file naming
                        $date = explode('_', $location);
                        if (count($output) > 0) {
                            $location = $location . '_invalid.csv';
                        } else {
                            $location = $location . '_valid.csv';
                        }
                        $this->insertAttendanceReport($location, end($date));
                    }
                    $this->saveFileOnServer($location);
                }
            } else {
                return false;
            }
        }
        return $output;
    }


    public function saveFileOnServer($location): void
    {
        if (!file_exists($location)) {
            // remove file name and create folder structure
            $location_ = explode('/', $location);
            array_pop($location_);
            $location_ = implode('/', $location_);
            mkdir($location_, recursive: true);
        }
        move_uploaded_file($this->filepath, $location);
    }
    /**
     * @description Create user accounts. This function must be used inside readCSV. This is a passive function.
     * i.e. function itself can not run.
     * @param $constructor : constructor of the account creation object. [class, 'constructor of factory pattern']
     *            example : [Student::class, 'createNewStudent'];
     * @param $csvFile : csvFile which was read by inbuilt fopen(). This is used in readCSV file function.
     * @return array [
     *              'valid' => Valid users as objects,
     *              'invalid' => Invalid format data such as index, email etc. OR
     *                          Uploading wrong file (Lecturer.csv for Student vise versa)
     *              'update' => Students who need to be updates (if the student is already in the database)
     * ]
     */
    public function readUserData($constructor, $csvFile): array
    {
        $valid = [];
        $invalid = [];
        $update = [];
        $header = fgetcsv($csvFile); # contains the column names

        while (($line = fgetcsv($csvFile)) !== FALSE) {
            $unwrappedData = User::unwrapData($line);
            // Check if the user type is correct, Student != Lecturer etc.
            if (!str_contains($constructor[0], User::getUserType($unwrappedData['regNo']))) {
                $invalid[] = $unwrappedData['regNo'];
            } elseif (User::validateUserAttrFromArray($unwrappedData)) { // Validate user attributes
                $newUser = call_user_func($constructor, $unwrappedData);
                if (!User::userExists($newUser->getRegNo())) { // Check if the user already exists
                    $valid[] = $newUser;
                } else { // If the user exists, add to update array
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
     * @description Assigns students to a course by reading a CSV file containing their registration numbers.
     * @param $csvFile - The CSV file containing the registration numbers of the students to be assigned.
     * @return array - Returns an array of invalid registration numbers that were not found in the database.
     */
    public function assignStudents($csvFile): array
    {
        $invalidRegNo = [];
        $valid = [];
        $invalidCourse = [];
        $exist = [];
        $fileName = $this->getFilename();
        if(Course::checkExists($fileName)){
            while (($line = fgetcsv($csvFile)) !== false) {
                $regNo = trim(array_shift($line));
                if (!User::userExists($regNo)) {
                    $invalidRegNo[] = $regNo;
                } else {
                    $valid[] = $regNo;
                }
            }
            if(sizeof($invalidRegNo)==0){
                foreach ($valid as $regNo){
                    $exist = Student::assignStudentsToCourse($regNo,$fileName);
                }
            }
        } else {
            $invalidCourse[] = $fileName;
        }
        return ['invalid' => $invalidRegNo, 'invalid_course' => $invalidCourse, 'exist' => $exist];
    }

    /**
    *@description Assigns students to a course by reading a CSV file containing their registration numbers and exam marks.
    *@param $csvFile - The CSV file containing the registration numbers and exam marks of the students to be assigned.
    *@return array - Returns an array of valid registration numbers and their corresponding exam marks.
     */
    public function uploadExamMarks($csvFile) : array
    {
        $student = [];
        $invalidStudent = [];

        $header = fgetcsv($csvFile);
        while (($line = fgetcsv($csvFile)) !== FALSE) {
            $unwrappedData = Course::unwrapExamMarks($line);
            $student['reg_no'][] = $unwrappedData['regNo'];
            $student['exam_mark'][] = $unwrappedData['marks'];
        }
        return $student;
    }

    // --------------------------------------------------------------------------------



    // ---------------------------Getters and Setters-----------------------------------
    /**
     * @return string
     */
    public function getFilename(): string
    {
        return substr($this->filename, 0, strpos($this->filename, '.'));
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
    // --------------------------------------------------------------------------------
}