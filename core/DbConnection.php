<?php

namespace app\core;

class DbConnection
{
    private \mysqli $db;
    private static DbConnection $instance;

    private function __construct($db)
    {
        $db_host = $db['host'] ?? '';
        $db_user = $db['user'] ?? '';
        $db_pass = $db['password'] ?? '';
        $db_name = $db['database'] ?? '';
        $db_port = $db['port'] ?? '';

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error($conn));
        }
        $this->db = $conn;
        mysqli_select_db($this->db, $db_name);
    }

    public static function getDatabaseInstance($db): DbConnection
    {
        if (!isset(static::$instance)) {
            static::$instance = new DbConnection($db);
        }
        return static::$instance;
    }

    public function select($table, $columns = '*', $where = null, $order = null, $limit = null): array
    {
        $sql = "SELECT $columns FROM $table";
        if ($where != null) {
            $sql .= " WHERE " . array_keys($where)[0] . "='" . array_values($where)[0] . "'";
            array_shift($where);
            foreach ($where as $key => $value) {
                $sql .= " AND $key = '$value'";
            }
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_assoc($result);
    }

    public function insert($table, $columns, $values): array
    {
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return mysqli_query($this->db, $sql);
    }

    public function update($table, $columns, $where): array
    {
        $sql = "UPDATE $table SET $columns WHERE $where";
        return mysqli_query($this->db, $sql);
    }

    public function delete($table, $where): array
    {
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->db, $sql);
    }

    public function setEmptyToNullColumns($table): array
    {
        foreach ($table as $key => $value) {
            if ($value == null) {
                $table[$key] = '';
            }
        }
        return $table;
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }
}