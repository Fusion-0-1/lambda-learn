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

    /**
     * @description Get database instance
     * @param $db
     * @return DbConnection
     */
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
    /**
     * @description Select data from database
     * @params $table, $columns, $join, $where, $like, $order, $limit
     * @return bool|\mysqli_result
     */
    public function select($table, $columns = '*', $join = null, $where = null, $like = null, $order = null, $limit = null)
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
        if ($like != null) {
            if ($where != null) {
                $sql .= " AND "; // Added 'AND' if 'where' condition exists
            } else {
                $sql .= " WHERE ";
            }
            $sql .= $this->addSQLLike($like);
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        return $this->db->query($sql);
    }

    /**
     * @description Insert data into database
     * @param $table
     * @param $values
     * @return bool|\mysqli_result
     */
    public function insert($table, $values)
    {
        $columns = "(" . implode(", ", array_keys($values)) . ")";
        $col_values = "('" . implode("','", array_values($values)) . "')";
        $sql = "INSERT INTO " . $table . $columns . " VALUES " . $col_values;
        return $this->db->query($sql);
    }

    /**
     * @description Check whether given data exists in database
     * @param $table
     * @param $primaryKey
     * @return bool
     */
    public function checkExists($table, $primaryKey): bool
    {
        $result = $this->select(
            table: $table,
            where: $primaryKey,
            limit: 1
        );
        return $this->rowCount($result) > 0;
    }

    /**
     * @description Update data in database
     * @param $table
     * @param $columns
     * @param $where
     * @param bool $math_formulae
     * @return bool|\mysqli_result
     */
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

    /**
     * @description Delete data from database
     * @param $table
     * @param $where
     * @return bool|\mysqli_result
     */
    public function delete($table, $where): bool|\mysqli_result
    {
        $sql = "DELETE FROM $table";
        $sql .= $this->addSQLWhere($where);
        return $this->db->query($sql);
    }

    /**
     * @param $result
     * @return bool|array|null
     */
    public function fetch($result): bool|array|null
    {
        return $result->fetch_assoc();
    }

    /**
     * @description Get number of rows in result
     * @param $result
     * @return int|string
     */
    public function rowCount($result): int|string
    {
        return $result->num_rows;
    }

    /**
     * @description If value is null, set it to empty string
     * @param $table
     * @return array
     */
    public function setEmptyToNullColumns($table): array
    {
        foreach ($table as $key => $value) {
            if ($value == null) {
                $table[$key] = '';
            }
        }
        return $table;
    }

    /**
     * @description Add WHERE clause to SQL query
     * @param $where
     * @param $operator
     * @return string
     */
    private function addSQLWhere($where, $operator = 'AND')
    {
        $sql = " WHERE " . array_keys($where)[0] . "='" . array_values($where)[0] . "'";
        array_shift($where);
        foreach ($where as $key => $value) {
            $sql .= " $operator $key = '$value'";
        }
        return $sql;
    }

    /**
     * @description Add LIKE clause to SQL query
     * @param $like
     * @return string
     */
    private function addSQLLike($like)
    {
        $sql = "";
        foreach ($like as $column => $value) {
            $sql .= " $column LIKE '%$value%' AND";
        }
        $sql = rtrim($sql, "AND");
        return $sql;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}