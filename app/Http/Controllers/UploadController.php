<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ShipmentImport;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use App\User;
use App\Shipment;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function token_f()
    {
        return session()->get('token.access_token');
    }
    public function importShipments(Request $request)
    {
        // dd($request->all());
        $orders = Excel::toArray(new ShipmentImport, request()->file('shipment'));
        $client_det = User::find($request->client);
        // dd($client);
        // $orders_col = Excel::toCollection(new OrderImport, request()->file('orders'));
        $arr = $orders[0];
        $data = array('data' => $arr, 'client' => $client_det);
        // dd($data);
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/importOrder', [
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
            $response = $request->getBody()->getContents();
            // dd($response);
        } catch (\Exception $e) {

            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }


        foreach ($arr as $key => $order) {
            // dd($order);
            $order_data = new Shipment();
            $order_data->order_id = $order["Order ID"];
            $order_data->airway_bill_no = $order["Order ID"];
            $order_data->bar_code = $order["Order ID"];
            $order_data->client_name = $order["Name of The client"];
            $order_data->client_address = $order["Address"];
            // $order_data-> = $order["Postal Code"];
            $order_data->client_city = $order["City"];
            // $order_data-> = $order["Region"];
            $order_data->client_phone = $order["Phone"];
            $order_data->cod_amount = $order["COD Amount"];

            $order_data->user_id = Auth::id();
            $order_data->status = 'Warehouse';
            $order_data->save();

            $order_data->client_email = $order['Sender mail'];
            $order_data->client_phone = $order['Phone'];
            $order_data->client_address = $order['Address'];
            $order_data->client_city = $order['City'];
            $order_data->amount_ordered = $order['quantity'];
            $order_data->client_region = $order['Region'];
            $order_data->user_id = Auth::id();
            $order_data->status = 'Warehouse';
            $order_data->shipment_id = random_int(1000000, 9999999);
            $order_data->paid = 0;
            $order_data->printReceipt = 0;
            $order_data->printed = 0;
            $order_data->sender_name = $client_det->name;
            $order_data->sender_email = $client_det->email;
            $order_data->sender_phone = $client_det->phone;
            $order_data->sender_address = $client_det->address;
            $order_data->sender_city = $client_det->city;
            $order_data->client_id = $client_det->client;
            // $order_data->country = $order->country;
            $order_data->country_id = $client_det->country_id;
            $order_data->save();
        }
        return redirect('/#/shipments');

    }
}
