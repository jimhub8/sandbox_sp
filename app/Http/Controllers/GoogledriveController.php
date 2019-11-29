<?php

namespace App\Http\Controllers;

use App\Shipment;
use App\Status;
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


class GoogledriveController extends Controller
{


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

    public function google_sheets(Request $request)
    {
        // dd($request->all());
        $client_id = $request->client;
        $sheet_name = $request->sheet_name;
        $sheet_no = $request->sheet_no;
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
            ->getByTitle($sheet_name);

        // dd($spreadsheet);
        // Get the first worksheet (tab)
        $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
        // dd(count($worksheets));
        if ($sheet_no > count($worksheets)) {
            abort(500, "The sheet number doesn't exist");
        }
        $worksheet = $worksheets[$sheet_no];

        $listFeed = $worksheet->getListFeed();
        // dd($listFeed);
        $representative = [];
        /** @var ListEntry */
        foreach ($listFeed->getEntries() as $entry) {
            $representative[] = $entry->getValues();
        }
        $this->check_order($representative, $client_id);
        // dd($representative);
        return redirect('/#/shipments');
    }


    public function check_order($orders, $client)
    {
        $order_arr = [];
        foreach ($orders as $order) {
            // dd($order);
            $shipment = Shipment::where('bar_code', '=', $order['orderno'])->first();
            if (!$shipment) {
                $shipment = new Shipment;
                $shipment->client_name = $order['clientname'];
                $shipment->client_phone = $order['phoneno'];
                $shipment->client_email = $order['product'];
                $shipment->client_address = $order['address'];
                // $shipment->client_city = $order['client_city'];
                $shipment->airway_bill_no = $order['orderno'];
                // $shipment->status = $order['status'];
                if (array_key_exists('status', $order)) {
                    if ($order['status'] == '' || $order['status'] == null) {
                        $status = 'Warehouse';
                    } else {
                        $status_lower = strtolower($order['status']);
                        $product_det = Status::select('name')->whereRaw('LOWER(name) = ?', $status_lower)->first();
                        if ($product_det) {
                            $status = $product_det->name;
                        } else {
                            $status = $order['status'];
                        }
                    }
                    $shipment->status = $status;
                    $shipment->derivery_status = $status;
                }
                $shipment->speciial_instruction = $order['instructions'];
                $shipment->booking_date = now();
                $shipment->derivery_date = $order['deliverydate'];
                $shipment->bar_code = $order['orderno'];
                // $shipment->to_city = $order['to_city'];
                $shipment->cod_amount = $order['price'];
                // $shipment->from_city = $order['from_city'];
                $shipment->sender_name = 'Speedball';
                $shipment->sender_email = 'info@speedballcourier.com';
                $shipment->sender_phone = '0700100010';
                $shipment->sender_address = 'Nairobi, Kenya';
                $shipment->sender_city = 'Nairobi';
                $shipment->amount_ordered = $order['qty'];
                $shipment->country_id = Auth::user()->country_id;
                $shipment->user_id = Auth::id();
                $shipment->client_id = $client;
                $shipment->save();
            }
        }
        // dd($order_arr);
        return;
    }
}
