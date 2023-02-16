<?php

namespace app\core;

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

    public function __construct($file)
    {
        $this->filename = $file['name'];
        $this->filepath = $file['tmp_name'];
        $this->filetype = $file['type'];
    }


    /**
     * @description Read the CSV file and unwrapped the columns data
     * @param $constructor
     * @return array|bool
     */
    public function readUserCSV($constructor): array|bool
    {
        $valid = [];
        $invalid = [];
        $update = [];

        if (!empty($this->filename) && in_array($this->filetype, self::csvMimes)) {
            if (is_uploaded_file($this->filepath)) {
                $csvFile = fopen($this->filepath, 'r');
                fgetcsv($csvFile);
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
                fclose($csvFile);
            } else {
                return false;
            }
        }

    return ['valid' => $valid, 'invalid' => $invalid, 'update' => $update];
    }
}