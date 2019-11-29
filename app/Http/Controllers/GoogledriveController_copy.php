<?php

namespace App\Http\Controllers;

use App\Shipment;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Statement;
use Revolution\Google\Sheets\Facades\Sheets;


class GoogledriveController_copy extends Controller
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
        // $records->getHeader();
        // dd($records);

        $records = $csv->getRecords();
        $newarray = array();
        foreach ($records as $key => $value) {
            $newarray[] =  $value;
        }
        dd($newarray);
        $this->check_order($newarray);

        // $order_arr = [];
        // foreach ($newarray as $order) {
        //     // dd($order['ORDER NO']);
        //     $shipment = Shipment::where('bar_code', '=', $order['ORDER NO'])->first();
        //     // dd($shipment);
        //     if ($shipment) {
        //         $order_arr[] = $order;
        //     } else {
        //         return 'test';
        //     }
        // }
        // dd($newarray);
        // $new_arr = unset($array[0]);

        // dd($new_arr);
    }

    public function check_order($orders)
    {
        $order_arr = [];
        foreach ($orders as $order) {
            // dd($order['ORDER NO']);
            $shipment = Shipment::where('bar_code', '=', $order['ORDER NO'])->first();
            if (!$shipment) {
                $shipment = new Shipment;
                $shipment->client_name = $order['CLIENT NAME'];
                $shipment->client_phone = $order['PHONE NO'];
                $shipment->client_email = $order['PRODUCT'];
                $shipment->client_address = $order['ADDRESS'];
                // $shipment->client_city = $order['client_city'];
                $shipment->airway_bill_no = $order['ORDER NO'];
                $shipment->status = $order['DELIVERY STATUS'];
                $shipment->derivery_status = $order['DELIVERY STATUS'];
                $shipment->speciial_instruction = $order['Instructions'];
                $shipment->booking_date = now();
                $shipment->derivery_date = $order['DELIVERY Date'];
                $shipment->bar_code = $order['ORDER NO'];
                // $shipment->to_city = $order['to_city'];
                $shipment->cod_amount = $order['PRICE'];
                // $shipment->from_city = $order['from_city'];
                $shipment->sender_name = 'Speedball';
                $shipment->sender_email = 'info@speedballcourier.com';
                $shipment->sender_phone = '0700100010';
                $shipment->sender_address = 'Nairobi, Kenya';
                $shipment->sender_city = 'Nairobi';
                $shipment->amount_ordered = $order['QTY'];
                $shipment->country_id = Auth::user()->country_id;
                $shipment->user_id = Auth::id();
                $shipment->save();
            }
        }
        dd($order_arr);
    }

    public function google_s()
    {

        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);
        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1RVeOSK1XtzXqV0guU3NTvWzd_zF5CPH5m_mUNIoSa_o';
        $range = 'Class Data!A2:E';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        if (empty($values)) {
            print "No data found.\n";
        } else {
            print "Name, Major:\n";
            foreach ($values as $row) {
                // Print columns A and E, which correspond to indices 0 and 4.
                printf("%s, %s\n", $row[0], $row[4]);
            }
        }
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient()
    {

        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $path = public_path('google/credentials.json');
        $client->setAuthConfig($path);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function google_sheets()
    {
        $path = public_path('google/googleserviceworker.json');
        // dd($path);
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $path);
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();

        $client->setApplicationName("Something to do with my representatives");
        $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);

        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }

        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($accessToken)
        );
        // Get our spreadsheet
        $spreadsheet = (new SpreadsheetService)
            ->getSpreadsheetFeed()
            ->getByTitle('courier sheet');

        // dd($spreadsheet);
        // Get the first worksheet (tab)
        $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
        $worksheet = $worksheets[1];

        $listFeed = $worksheet->getListFeed();
        // dd($listFeed);
        $representative = [];
        /** @var ListEntry */
        foreach ($listFeed->getEntries() as $entry) {
            $representative[] = $entry->getValues();
        }
        dd($representative);
    }
}
