<?php
require 'vendor/autoload.php';
// отключаем предупрежения об ошибках - в библиотеке для google.docs они есть, но на работу не влияют
error_reporting(0);

return array (
    'driver'        =>  'mysql',
    'host'          =>  'localhost',
    'database_name' =>  'recruits',
//    'database_name' =>  'debesir1_test',
    'username'      =>  'root',
//    'username'      =>  'debesir1_testuser',
    'password'      =>  '',
//    'password'      =>  'X8O%42-.CdNK',

    'spreadsheet_id' => '1ithKcEsByQgswy5NHEEPghyzZK8d8eL6ahpoG3Xhyko',
    'spreadsheet_url' => 'https://docs.google.com/spreadsheets/d/1ithKcEsByQgswy5NHEEPghyzZK8d8eL6ahpoG3Xhyko/edit#gid=0',
);