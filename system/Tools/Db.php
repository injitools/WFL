<?php

/**
 * Class Db
 *
 * Wrapper for working with the database
 */
class Db {
    /**
     * @var PDO
     */
    public $connection;

    /**
     * Db constructor.
     */
    function __construct() {
        $config = App::$cur->config->get('db');
        $this->connection = new PDO("mysql:host={$config['host']};dbname={$config['db']}", $config['user'], $config['pass'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,]);
    }

    /**
     * Insert new row to table and return id of inserted row
     *
     * @param string $table
     * @param array $fields
     * @return int
     */
    function insert($table, $fields) {
        $query = "INSERT INTO";
        //(name, value) VALUES (:name, :value)";
        $query .= " {$table} ";
        $query .= ' (' . implode(',', array_keys($fields)) . ') ';
        $query .= ' VALUES (' . trim(str_repeat(', ?', count($fields)), ',') . ') ';
        $this->query($query, array_values($fields));
        return $this->connection->lastInsertId();

    }

    /**
     * Execute query and return result
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute(array_values($params));
        return $stmt;
    }

    /**
     * Select rows from table
     *
     * @param array $params
     * @return array
     */
    function select($params) {
        $query = 'SELECT * FROM ' . $params['table'] . ' WHERE ' . $params['where']['query'] . ' LIMIT ' . $params['limit'];
        return $this->query($query, $params['where']['params'])->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new table in DB
     *
     * @param string $tableName
     * @param array $cols
     * @return PDOStatement
     */
    function createTable($tableName, $cols) {
        $query = "CREATE TABLE {$tableName} (";
        foreach ($cols as $colName => $param) {
            $query .= " `{$colName}` {$param},";
        }
        $query = rtrim($query, ',');
        $query .= ") ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci";
        return $this->query($query);
    }
}