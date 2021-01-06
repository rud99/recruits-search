<?php

use Services\Database;
use Services\GoogleDocs;

require 'config.php';
require 'helpers.php';
require 'Services/Database.php';
require 'Services/GoogleDocs.php';

try {
    $db = new Database();
    $people = $db->getByFieldAndCondition('people ', 'age', 18, '>');
    if ($people) {
//        exportToSheets($people);
        $gd = new  GoogleDocs();
        $gd->exportToSheets($people);
        $code = 200;
        $message = "Данные успешно выгружены в <a href=".config('spreadsheet_url').">Google документ</a>";
    } else {
        $code = 200;
        $message = 'Данных для экспорта в Google.docs нет!';
    }
} catch (Exception $e) {
    $code = $e->getCode();
    $message = $e->getMessage();
}
echo json_encode([
    'status' => $code,
    'message' => $message
]);



/*function exportToSheets(array $data) {
    $client = new \Google_Client();
    $client->setApplicationName('Google Sheets and PHP');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType('offline');
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = config('spreadsheet_id');

    // очищаем ячейки от старой информации
    clearSheets($service, $spreadsheetId);

    $update_range = "Лист1!A6";
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $data
    ]);
    $params = ['valueInputOption' => 'RAW'];
    $service->spreadsheets_values->update($spreadsheetId, $update_range, $body, $params);
}

function clearSheets(Google_Service_Sheets $service, $spreadsheetId) {
    $requests = [
        new Google_Service_Sheets_Request( [
            'deleteRange' => [
                'range'          => [
                    'sheetId' => '0',
                    'startRowIndex' => 5,
                    'endRowIndex' => 100,
                    'startColumnIndex' => 0,
                    'endColumnIndex' => 4
                ],
                'shiftDimension' => 'ROWS'
            ]
        ] )
    ];
    $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest( [
        'requests' => $requests
    ] );

    $service->spreadsheets->batchUpdate( $spreadsheetId, $batchUpdateRequest );
}*/
