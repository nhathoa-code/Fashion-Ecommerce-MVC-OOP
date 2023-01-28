<?php
require_once __DIR__ . "/../config.php";
class Database
{
    protected $conn;
    public function __construct()
    {
        $DATABASE_NAME = DATABASE_NAME;
        $dburl = "mysql:host=localhost;dbname=$DATABASE_NAME;charset=utf8";
        $username = DATABASE_USER_NAME;
        $password = DATABASE_PASSWORD;
        $this->conn = new PDO($dburl, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct()
    {
        unset($this->conn);
    }

    public function pdo_execute($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function pdo_query($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function pdo_query_column($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $rows;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function pdo_query_one($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    function pdo_query_value($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return array_values($row)[0];
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
