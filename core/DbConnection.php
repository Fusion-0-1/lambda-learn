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

        $conn = new \mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
        if ($conn->connect_error) {
            die('Could not connect: ' . $conn->connect_error);
        }
        $this->db = $conn;
        $conn->select_db($db_name);
    }

    public static function getDatabaseInstance($db): DbConnection
    {
        if (!isset(static::$instance)) {
            static::$instance = new DbConnection($db);
        }
        return static::$instance;
    }

    /*
     * @param bool $getAsArray: If true, returns the result as an array.
     *                          If false, returns the result as an object of mysqli_query.
     */
    public function select($table, $columns = '*', $where = null, $order = null, $limit = null, $getAsArray=true)
    {
        $sql = "SELECT $columns FROM $table";
        if ($where != null) {
            $sql .= $this->addSQLWhere($where);
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $result = $this->db->query($sql);
        if (!$getAsArray) {
            return $result;
        }

        return $result->fetch_assoc();
    }

    public function insert($table, $columns, $values): array
    {
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->db->query($sql);
    }

    public function update($table, $columns, $where): bool|\mysqli_result
    {
        $sql = "UPDATE $table";

        $sql .= " SET ";
        foreach ($columns as $key => $value) {
            $sql .= "$key = '$value', ";
        }
        $sql = substr($sql, 0, -2);

        $sql .= $this->addSQLWhere($where);

        return $this->db->query($sql);
    }

    public function delete($table, $where): bool|\mysqli_result
    {
        $sql = "DELETE FROM $table";
        $sql .= $this->addSQLWhere($where);
        return $this->db->query($sql);
    }

    public function fetch($result): bool|array|null
    {
        return $result->fetch_assoc();
    }

    public function rowCount($result): int|string
    {
        return $result->num_rows;
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

    private function addSQLWhere($where)
    {
        $sql = " WHERE " . array_keys($where)[0] . "='" . array_values($where)[0] . "'";
        array_shift($where);
        foreach ($where as $key => $value) {
            $sql .= " AND $key = '$value'";
        }
        return $sql;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}