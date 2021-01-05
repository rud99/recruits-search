<?php

use Services\Database;

require 'config.php';
require 'helpers.php';
require 'Services/Database.php';

$data = $_POST;

try {
    $db = new Database();
    $db->insertSingleRecord('people ', json_decode($data['data'], true));
    $code = 200;
    $message = 'Данные успешно добавлены!';
} catch (Exception $e) {
    $code = $e->getCode();
    $message = $e->getMessage();
}
echo json_encode([
    'status' => $code,
    'message' => $message
]);
