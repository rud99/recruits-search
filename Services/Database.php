<?php

namespace Services;

use PDO;

class Database
{
    private $pdo;

    /**
     * Просто создаем новый объект PDO в атрибуте pdo
     * настройки берутся из конфига
     *
     * Database constructor.
     */
    public function __construct()
    {
        $this->pdo = new PDO(config('driver').":
                                host=".config('host').";
                                dbname=".config('database_name'),
            config('username'),
            config('password'));
    }

    /**
     * Вставляет в БД 1 запись
     *
     * @param $table
     * @param array $data
     * @return bool
     */
    public function insertSingleRecord($table, array $data)
    {
        $fields = implode(", ",array_keys($data));
        $tags = ":" . implode(", :",array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($tags)";
        //Сформировать запрос
        $statement = $this->pdo->prepare($sql);
        //Выполнить
        if ($statement->execute($data)) return true;

        return false;
    }


    /**
     * Получение данных из БД по одному из реквизитов
     *
     * @param $table
     * @param $field
     * @param $data
     * @return array
     */

    public function getByOneField($table, $field, $data)
    {
        $sql = "SELECT * FROM $table WHERE $field = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получение данных из таблицы по условию на 1 поле
     * @param $table
     * @param $field
     * @param $value
     * @param string $condition
     * @return array
     */
    public function getByFieldAndCondition($table, $field, $value, $condition = "=")
    {
        $sql = "SELECT * FROM $table WHERE $field $condition :$field";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$field => $value]);

        return $statement->fetchAll(PDO::FETCH_NUM);
    }
}