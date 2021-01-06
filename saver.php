<?php

use Services\Database;

require 'config.php';
require 'helpers.php';
require 'Services/Database.php';

$data = $_POST;


$errors = [];

if (trim($data['data']['name']) == '') $errors[] = 'Введите имя!';
if (trim($data['data']['surname']) == '') $errors[] = 'Введите фамилию!';
if (trim($data['data']['age']) == '') $errors[] = 'Введите возраст!';

if (empty($errors)) {
    try {
        $db = new Database();
        $db->insertSingleRecord('people ', json_decode($data['data'], true));
        $code = 200;
        $message = 'Данные успешно добавлены!';
    } catch (Exception $e) {
        $code = $e->getCode();
        $message = $e->getMessage();
    }
} else {
    $code = 'error';
    $message = array_shift($errors);
}

echo json_encode([
    'status' => $code,
    'message' => $message
]);
