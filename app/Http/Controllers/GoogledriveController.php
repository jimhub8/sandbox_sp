<?php

namespace App\Http\Controllers;

use App\Imports\ShipmentImport;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use League\Csv\Reader;
use League\Csv\Statement;
use Maatwebsite\Excel\Facades\Excel;

class GoogledriveController extends Controller
{
    public function google_drive()
    {
        $client = new Google_Client();
        $path = public_path('google/googleserviceworker.json');
        // dd($path);
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $path);
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Drive::DRIVE);
        $driveService = new Google_Service_Drive($client);
        // $response = $driveService->files->listFiles();
        // dd($response);

        $fileID = '1RVeOSK1XtzXqV0guU3NTvWzd_zF5CPH5m_mUNIoSa_o';
        $response = $driveService->files->export($fileID, 'text/csv', array(
            'alt' => 'media'
        ));
        // $orders = Excel::toArray(new ShipmentImport, $response);
        $content = $response->getBody()->getContents();
        // dd($content);

        $csv = Reader::createFromString($content);
        // dd($csv);
        // $csv->setHeaderOffset(0);
        $csv->setHeaderOffset(0);
        $records = (new Statement())->process($csv);
        $records->getHeader();
        dd($records);

        $records = $csv->getRecords();
        $newarray = array();
        foreach ($records as $key => $value) {
            $newarray[] =  $value;
        }
        dd($newarray);
        // $new_arr = unset($array[0]);

        // dd($new_arr);
    }
}
