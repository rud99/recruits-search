<?php

namespace Services;

use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_Request;
use Google_Service_Sheets_ValueRange;

class GoogleDocs
{
    private $client;
    private $service;
    private $spreadsheetId;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('Google Sheets and PHP');
        $this->client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAccessType('offline');
        $this->client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/credentials.json');

        $this->service = new Google_Service_Sheets($this->client);

        $this->spreadsheetId = config('spreadsheet_id');
    }

    public function exportToSheets(array $data) {
        $this->clearSheets();

        $update_range = "Лист1!A6";
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);
        $params = ['valueInputOption' => 'RAW'];
        $this->service->spreadsheets_values->update($this->spreadsheetId, $update_range, $body, $params);
    }

    private function clearSheets() {
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

        $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }
}