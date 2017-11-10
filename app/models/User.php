<?php


class User extends \Model {
    public static $tableName = 'User';
    public static $cols = [
        'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
        'name' => 'VARCHAR(255)',
        'email' => 'VARCHAR(255)',
        'password' => 'VARCHAR(255)',
        'sex' => 'TINYINT(1)',
        'avatar' => 'VARCHAR(255)',
    ];


}