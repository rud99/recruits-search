<?php

require 'vendor/autoload.php';
require 'config.php';
require 'helpers.php';
//require 'Services/Database.php';


//var_dump(11111);die;
//Reading data from spreadsheet.

$client = new \Google_Client();

$client->setApplicationName('Google Sheets and PHP');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
//var_dump($service); die;
$spreadsheetId = "1ithKcEsByQgswy5NHEEPghyzZK8d8eL6ahpoG3Xhyko";

$get_range = "Лист1!A1:E1";
//Request to get data from spreadsheet.

$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);

$values = $response->getValues();


var_dump($values); die;