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
     * $join = [
     *  [
     *       'table' => 'table_name',
     *      'on' => 'table_name.column_name = table_name.column_name'
     *  ],
     * ]
     */
    public function select($table, $columns = '*', $join = null, $where = null, $order = null, $limit = null)
    {
        if ($columns != '*') {
            $columns = implode(', ', $columns);
        }
        $sql = "SELECT $columns FROM $table";
        if ($join != null) {
            foreach ($join as $joinTable) {
                $sql .= " JOIN {$joinTable['table']} ON {$joinTable['on']}";
            }
        }
        if ($where != null) {
            $sql .= $this->addSQLWhere($where);
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        return $this->db->query($sql);
    }

    public function insert($table, $values)
    {
        $columns = "(" . implode(", ", array_keys($values)) . ")";
        $col_values = "('" . implode("','", array_values($values)) . "')";
        $sql = "INSERT INTO " . $table . $columns . " VALUES " . $col_values;
        return $this->db->query($sql);
    }

    public function checkExists($table, $primaryKey): bool
    {
        $result = $this->select(
            table: $table,
            where: $primaryKey,
            limit: 1
        );
        return $this->rowCount($result) > 0;
    }

    public function update($table, $columns, $where, $math_formulae = false): bool|\mysqli_result
    {
        $sql = "UPDATE $table";

        $sql .= " SET ";
        foreach ($columns as $key => $value) {
            if ($math_formulae) {
                $sql .= "$key = $value, ";
            } else {
                $sql .= "$key = '$value', ";
            }
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

    private function addSQLWhere($where, $operator = 'AND')
    {
        $sql = " WHERE " . array_keys($where)[0] . "='" . array_values($where)[0] . "'";
        array_shift($where);
        foreach ($where as $key => $value) {
            $sql .= " $operator $key = '$value'";
        }
        return $sql;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}