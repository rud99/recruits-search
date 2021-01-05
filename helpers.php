<?php

/**
 * Получаем значение параметров из конфигурационного файла
 * @param $field
 * @return mixed
 */
function config($field)
{
    $config = require 'config.php';
    return $config[$field];
}