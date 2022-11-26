<?php

namespace app\core;

class DbConnection
{
    public \mysqli $db;
    public function __construct($db)
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

    public function select($table, $columns = '*', $where = null, $order = null, $limit = null)
    {
        $sql = "SELECT $columns FROM $table";
        if ($where != null) {
            $sql .= " WHERE $where";
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
}