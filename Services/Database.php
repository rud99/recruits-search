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
     *
     * Вставка в БД множества строк единым запросом
     *
     * @param $table
     * @param array $data
     * @return bool
     */


    public function multiInsert($table, array $data)
    {
        $this->pdo->beginTransaction();

        $fields = implode(", ", array_keys($data[0]));
        $sql = "INSERT INTO $table ($fields) VALUES ";
        $insertQuery = array();
        $insertData = array();
        foreach ($data as $row) {
            $insertQuery[] = '(?, ?, ?)';
            $insertData = array_merge($insertData, array_values($row));
        }
        if (!empty($insertQuery)) {
            $sql .= implode(', ', $insertQuery);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($insertData);
        }

        return $this->pdo->commit();
    }

    /**
     * Добавление в БД данных из массива при отсутствии и обновлении при наличии
     *
     * @param $table
     * @param array $data
     * @param array $updFieds
     * @return bool
     */
    public function insertWithUpd($table, array $data, array $updFieds)
    {
        $this->pdo->beginTransaction();

        $fields = implode(", ", array_keys($data[0]));
        $sql = "INSERT INTO $table ($fields) VALUES ";
        $insertQuery = array();
        $insertData = array();
        //собираем плейсхолдеры
        $holders = makePlsholders(count($data[0]));
        // собираем строку для указания какие поля на что обновлять
        $fieldSrt = makeUpdPlsholders($updFieds);

        foreach ($data as $row) {
            $insertQuery[] = $holders;
            $insertData = array_merge($insertData, array_values($row));
        }

        if (!empty($insertQuery)) {
            $sql .= implode(', ', $insertQuery)." ON DUPLICATE KEY UPDATE ".$fieldSrt;
            var_dump($sql);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($insertData);
        }

        return $this->pdo->commit();
    }



    /**
     * Вставка в БД множества строк
     *
     * @param $table
     * @param array $data
     */
    public function insertManyRecords($table, array $data)
    {
        foreach ($data as $item) {
            $this->insertSingleRecord($table, $item);
        }
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
     * Удаление записи
     *
     * @param $table
     * @param $field
     * @param $data
     * @return bool
     */

    public function delete($table, $field, $data)
    {
        $sql = "DELETE FROM $table WHERE $field =  ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);

        return true;
    }

    /**
     * Получить все поля из БД по нескольким условиям
     * имена полей - ключи входного массива $data
     *
     * @param $table
     * @param array $data
     * @param string $operand
     * @return array
     */


    public function getByFields($table, array $data, $operand = "AND")
    {
        $sql = "SELECT * FROM $table WHERE ";

        // необходимость конструкции AND или OR
        $num = 1;
        $append = $operand;
        foreach ($data as $key => $value) {
            // подсчитываем четность или не четность
            if (($num % 2) == 0) $append = '';
            $sql .= $key." = :".$key." ".$append." ";
            $num++;
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update 1 поля по ID
     *
     * @param $table
     * @param $updField
     * @param $data
     * @param $id
     * @return bool
     */

    public function updateOneFieldById($table, $updField, $data, $id)
    {
        $field = $updField." = :".$updField;
        $sql = "UPDATE $table SET $field WHERE ID = :ID";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':Value', $Value);
        $statement->bindParam(':ID', $ID);
        $Value = $data;
        $ID = $id;
        $statement->execute();

        return true;
    }
}