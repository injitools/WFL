<?php

/**
 * Class Model
 *
 * Describes objects in the database
 */
class Model {
    /**
     * @var string
     */
    public static $tableName = '';
    /**
     * @var array
     */
    public static $cols = [];
    /**
     * @var array
     */
    public $__params = [];
    /**
     * @var bool
     */
    public $inDb = false;

    /**
     * @param Form $form
     * @return static
     */
    public static function fromForm($form) {
        $model = new static();
        foreach ($form->inputs as $input) {
            if (isset(static::$cols[$input->name])) {
                $model->{$input->name} = $input->forDb();
            }
        }
        return $model;
    }

    /**
     * @param array $array
     * @return static
     */
    public static function fromDbArray($array) {
        $model = new static();
        $model->inDb = true;
        foreach ($array as $key => $value) {
            if (isset(static::$cols[$key])) {
                $model->$key = $value;
            }
        }
        return $model;
    }

    /**
     * Setter for model params
     *
     * @param string $name
     * @param mixed $value
     */

    public function __set($name, $value) {
        $this->__params[$name] = $value;
    }

    /**
     * Getter fro model params
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return $this->__params[$name];
    }

    /**
     * Save model to db
     *
     * TODO: Update object in db
     */
    public function save() {
        try {
            if (!$this->inDb) {
                $this->id = App::$cur->db->insert(static::$tableName, $this->__params);
                $this->inDb = true;
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '42S02') {
                static::createTable();
                $this->save();
            } else {
                throw $e;
            }
        }
    }

    /**
     * Get object from db by query
     *
     * @param array $param
     * @return bool|static
     */
    public static function getOne($param) {
        try {
            $result = App::$cur->db->select(['table' => static::$tableName, 'where' => $param['where'], 'limit' => 1]);
            if ($result) {
                return static::fromDbArray($result[0]);
            }
            return false;
        } catch (PDOException $e) {
            if ($e->getCode() == '42S02') {
                static::createTable();
                static::getOne($param);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Create object table in db
     */
    public static function createTable() {
        App::$cur->db->createTable(static::$tableName, static::$cols);
    }
}