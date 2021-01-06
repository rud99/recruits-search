<?php
// отключаем предупрежения об ошибках - в библиотеке для google.docs они есть, но на работу не влияют
error_reporting(0);

return array (
    'driver'        =>  'mysql',
    'host'          =>  'localhost',
    'database_name' =>  'recruits',
    'username'      =>  'root',
    'password'      =>  '',
    
    'spreadsheet_id' => '1ithKcEsByQgswy5NHEEPghyzZK8d8eL6ahpoG3Xhyko',
    'spreadsheet_url' => 'https://docs.google.com/spreadsheets/d/1ithKcEsByQgswy5NHEEPghyzZK8d8eL6ahpoG3Xhyko/edit#gid=0',
);