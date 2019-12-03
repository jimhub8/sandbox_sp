<?php

namespace App\Http\Controllers;

use App\Client as AppClient;
use App\Shipment;
use App\Status;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Statement;
use Revolution\Google\Sheets\Facades\Sheets;


class GoogledriveController extends Controller
{
    public function token_f()
    {
        return session()->get('token.access_token');
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

    public function google_sheets(Request $request)
    {
        // dd($request->all());
        $client_id = $request->client;
        $client_details = AppClient::find($client_id);
        $sheet_name = $request->sheet_name;
        $work_sheet = $request->work_sheet;
        // $path = public_path('google/googleserviceworker.json');
        $path = public_path('google/googlesheets.json');
        // dd($path);
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $path);
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();

        $client->setApplicationName("Google Sheet Orders");
        $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);

        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }

        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($accessToken)
        );
        // dd($work_sheet, $sheet_name);
        // Get our spreadsheet
        $spreadsheet = (new SpreadsheetService)
            ->getSpreadsheetFeed()
            ->getByTitle($sheet_name);

        // Get the first worksheet (tab)
        // $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
        $worksheet = $spreadsheet->getWorksheetFeed()->getByTitle($work_sheet);
        // dd($worksheet);
        // foreach ($worksheets as $worksheet) {
        // }
        // dd($worksheets);
        // $worksheets = $worksheets->getByTitle('Sheet1');

        // if ($sheet_no > count($worksheets)) {
        //     abort(404, "The sheet number doesn't exist");
        // }
        // $worksheet = $worksheets[$sheet_no];
        // dd($worksheet);

        $listFeed = $worksheet->getListFeed();
        // dd($listFeed);
        $representative = [];
        /** @var ListEntry */
        foreach ($listFeed->getEntries() as $entry) {
            $representative[] = $entry->getValues();
        }

        $data['data'] = $representative;
        $data['client'] = $client_details;

        // dd(($representative));
        $this->update_status($data);
        $this->check_order($representative, $client_details);
        return redirect('/#/shipments');
    }


    public function check_order($orders, $client)
    {
        $order_arr = [];
        foreach ($orders as $order) {
            // dd($order);
            $shipment = Shipment::where('bar_code', '=', $order['orderid'])->first();
            if (!$shipment) {
                $shipment = new Shipment;
                $shipment->client_name = $order['nameoftheclient'];
                $shipment->client_phone = $order['phone'];
                $shipment->client_email = $order['productname'];
                $shipment->client_address = $order['address'];
                // $shipment->client_city = $order['client_city'];
                $shipment->airway_bill_no = $order['orderid'];
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
                $shipment->speciial_instruction = $order['specialinstructions'];
                $shipment->booking_date = now();
                $shipment->derivery_date = $order['deliverydate'];
                $shipment->bar_code = $order['orderid'];
                // $shipment->to_city = $order['to_city'];
                $shipment->cod_amount = $order['codamount'];
                // $shipment->from_city = $order['from_city'];
                $shipment->sender_name = $client->name;
                $shipment->sender_email = $client->email;
                $shipment->sender_phone = $client->phone;
                $shipment->sender_address = $client->address;
                $shipment->sender_city = $client->city;
                $shipment->amount_ordered = $order['quantity'];
                $shipment->country_id = Auth::user()->country_id;
                $shipment->user_id = Auth::id();
                $shipment->client_id = $client;
                $shipment->save();
            }
        }
        // dd($order_arr);
        return;
    }

    public function update_status($data)
    {

        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/googleSheet', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token_f(),
                ],
                'body' => json_encode([
                    'data' => $data,
                ])
            ]);
            // $response = $http->get(env('API_URL').'/api/getUsers');
            return $response = $request->getBody()->getContents();
            // dd($response);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }
}
