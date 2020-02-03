<?php

namespace App\Http\Controllers;

use App\Client as AppClient;
use App\Jobs\ShipmentJob;
use App\models\Apimft;
use App\Shipment;
use App\Status;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Sheets;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoogledriveController extends Controller
{
    public function token_f()
    {
        // return session()->get('token.access_token');

        $token = Apimft::where('user_id', Auth::id())->first();
        if ($token) {
            return $token->access_token;
        }else {
            abort(401);
        }
    }

    public function google_sheets(Request $request)
    {
        // dd($request->all());
        $client_id = $request->client;
        $client_details = AppClient::find($client_id);
        // dd($client_details);
        $sheet_name = $request->sheet_name;
        $work_sheet = $request->work_sheet;
        // $path = public_path('google/googleserviceworker.json'); sandbox
        $path = public_path('google/googlesheets.json');

        $work_sheet = $request->work_sheet;
        // $path = '/home/speedbal/web.speedballcourier.com/google/googlesheets.json';
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

        $statuses = Status::all();
        $data['data'] = $representative;
        $data['client'] = $client_details;
        $data['status'] = $statuses;
        // dd(($representative));

        $this->update_status($data);
        $this->check_order($representative, $client_details);
        return redirect('/#/shipments');
    }

    public function check_order($orders, $client)
    {
        $order_arr = [];
        $shipment_array = [];
        foreach ($orders as $order) {
            // dd($order);
            $order_id = ' '.$order["orderid"];
            $shipment = Shipment::where('bar_code', '=', $order['orderid'])->orWhere('bar_code', $order_id)->exists();
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
                $shipment->derivery_date = ($order['deliverydate']) ? $order['deliverydate'] : null;
                $shipment->bar_code = $order['orderid'];
                // $shipment->to_city = $order['to_city'];
                $shipment->cod_amount = (int)$order['codamount'];
                // $shipment->from_city = $order['from_city'];
                $shipment->sender_name = $client->name;
                $shipment->sender_email = $client->email;
                $shipment->sender_phone = $client->phone;
                $shipment->sender_address = $client->address;
                $shipment->sender_city = $client->city;
                $shipment->amount_ordered = $order['quantity'];
                $shipment->country_id = Auth::user()->country_id;
                $shipment->user_id = Auth::id();
                $shipment->client_id = $client->id;
                $shipment->created_at = now();
                $shipment->updated_at = now();
                // $shipment->save();
                $shipment_array[] = $shipment;
            }
        }

        if (!empty($shipment_array)) {
            $shipment_array = collect($shipment_array); // Make a collection to use the chunk method
            // it will chunk the dataset in smaller collections containing 300 values each.
            // Play with the value to get best result
            $chunks = $shipment_array->chunk(300);
            foreach ($chunks as $chunk) {
                DB::table('shipments')->insert($chunk->toArray());
            }
            return;
        }

        // dd($order_arr);
        return;
    }

    public function update_status($data)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/googleSheet', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
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

            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }
}
