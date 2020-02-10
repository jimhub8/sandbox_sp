<?php

namespace App\Http\Controllers;

use App\Client as AppClient;
use Illuminate\Http\Request;
use App\Imports\ShipmentImport;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use App\User;
use App\Shipment;
use App\Status;
use Illuminate\Support\Facades\Auth;
use App\models\Apimft;

class UploadController extends Controller
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
    public function update_status($data)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/importOrder', [
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

    // public function importShipments(Request $request)
    // {
    //     $orders = Excel::toArray(new ShipmentImport, request()->file('shipment'));
    //     $client_det = AppClient::find($request->client);
    //     // dd($orders);
    //     // $orders_col = Excel::toCollection(new OrderImport, request()->file('orders'));
    //     $status = Status::all();
    //     $arr = $orders[0];
    //     $data = array('data' => $arr, 'client' => $client_det, 'status' => $status);
    //     // dd($data);
    //     // try {
    //     //     $client = new Client();
    //     //     $request = $client->request('POST', env('API_URL') . '/api/importOrder', [
    //     //         'headers' => [
    //     //             'Content-type' => 'application/json',
    //     //             'Accept' => 'application/json',
    //     //             'Authorization' => 'Bearer ' . $this->token_f(),
    //     //         ],
    //     //         'body' => json_encode([
    //     //             'data' => $data,
    //     //         ])
    //     //     ]);
    //     //     // $response = $http->get(env('API_URL').'/api/getUsers');
    //     //     return $response = $request->getBody()->getContents();
    //     //     // dd($response);
    //     // } catch (\Exception $e) {

    //     //     \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
    //     //     $code = $e->getResponse()->getStatusCode();
    //     //     if ($code == 401) {
    //     //         abort(401);
    //     //     }
    //     //     return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
    //     // }

    //     $this->update_status($data);
    //     foreach ($arr as $key => $order) {
    //         $order_exists = Shipment::where('bar_code', $order["order_id"])->first();
    //         if (!$order_exists) {
    //             // dd($order['delivery_date']);
    //             $order_data = new Shipment();
    //             $order_data->order_id = $order["order_id"];
    //             $order_data->airway_bill_no = $order["order_id"];
    //             $order_data->bar_code = $order["order_id"];
    //             $order_data->client_name = $order["name_of_the_client"];
    //             $order_data->client_address = $order["address"];
    //             // $order_data-> = $order["Postal Code"];
    //             $order_data->client_city = $order["city"];
    //             // $order_data-> = $order["Region"];
    //             $order_data->client_phone = $order["phone"];
    //             $order_data->cod_amount = $order["cod_amount"];

    //             $order_data->user_id = Auth::id();

    //             if (array_key_exists('status', $order)) {
    //                 if ($order['status'] == '' || $order['status'] == null) {
    //                     $status = 'Warehouse';
    //                 } else {
    //                     $status_lower = strtolower($order['status']);
    //                     $product_det = Status::select('name')->whereRaw('LOWER(name) = ?', $status_lower)->first();
    //                     if ($product_det) {
    //                         $status = $product_det->name;
    //                     } else {
    //                         $status = $order['status'];
    //                     }
    //                 }
    //                 $order_data->status = $status;
    //             } else {
    //                 $order_data->status = 'Warehouse';
    //             }
    //             // dd($order_data->status);

    //             if (array_key_exists('delivery_date', $order)) {
    //                 // dd($order);
    //                 if ($order['delivery_date'] == '' || $order['delivery_date'] == null) {
    //                     $delivery_date = null;
    //                 } else {
    //                     $delivery_date = $order['delivery_date'];
    //                 }
    //                 $order_data->derivery_date = $delivery_date;
    //             }

    //             // $instructions = (array_key_exists('special_instructions', $order)) ? $order['special_instructions'] : $order['instructions'];
    //             $instructions = (array_key_exists('special_instructions', $order)) ? $order['special_instructions'] : null;

    //             if ($instructions) {
    //                 // dd($order);
    //                 if ($instructions == '' || $instructions == null) {
    //                     $instructions = null;
    //                 } else {
    //                     $instructions = $instructions;
    //                 }
    //                 $order_data->speciial_instruction = $instructions;
    //             }

    //             // if (array_key_exists('instructions', $order)) {
    //             //     // dd($order);
    //             //     if ($order['instructions'] == '' || $order['instructions'] == null) {
    //             //         $instructions = null;
    //             //     } else {
    //             //         $instructions = $order['instructions'];
    //             //     }
    //             //     $order_data->speciial_instruction = $instructions;
    //             // }
    //             // $order_data->client_email = $order['sender_mail'];
    //             $order_data->client_email = (array_key_exists('sender_mail', $order)) ? $order['sender_mail'] : $order['product_name'];

    //             $order_data->client_phone = $order['phone'];
    //             $order_data->client_address = $order['address'];
    //             $order_data->client_city = (array_key_exists('city', $order)) ? $order['city'] : null;
    //             $order_data->amount_ordered = $order['quantity'];
    //             $order_data->client_region = (array_key_exists('region', $order)) ? $order['region'] : null;
    //             $order_data->user_id = Auth::id();
    //             $order_data->shipment_id = random_int(1000000, 9999999);
    //             $order_data->paid = 0;
    //             $order_data->printReceipt = 0;
    //             $order_data->printed = 0;
    //             $order_data->sender_name = $client_det->name;
    //             $order_data->sender_email = $client_det->email;
    //             $order_data->sender_phone = $client_det->phone;
    //             $order_data->sender_address = $client_det->address;
    //             $order_data->sender_city = $client_det->city;
    //             $order_data->client_id = $request->client;
    //             // $order_data->country = $order->country;
    //             $order_data->country_id = Auth::user()->country_id;
    //             $order_data->save();
    //         }
    //     }
    //     return redirect('/#/shipments');
    // }



    public function importShipments(Request $request)
    {
        $orders = Excel::toArray(new ShipmentImport, request()->file('shipment'));
        $client_det = AppClient::find($request->client);
        // dd($orders);
        // $orders_col = Excel::toCollection(new OrderImport, request()->file('orders'));
        $status = Status::all();
        $arr = $orders[0];
        $data = array('data' => $arr, 'client' => $client_det, 'status' => $status);
        // dd($data);
        // try {
        //     $client = new Client();
        //     $request = $client->request('POST', env('API_URL') . '/api/importOrder', [
        //         'headers' => [
        //             'Content-type' => 'application/json',
        //             'Accept' => 'application/json',
        //             'Authorization' => 'Bearer ' . $this->token_f(),
        //         ],
        //         'body' => json_encode([
        //             'data' => $data,
        //         ])
        //     ]);
        //     // $response = $http->get(env('API_URL').'/api/getUsers');
        //     return $response = $request->getBody()->getContents();
        //     // dd($response);
        // } catch (\Exception $e) {

        //     \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
        //     $code = $e->getResponse()->getStatusCode();
        //     if ($code == 401) {
        //         abort(401);
        //     }
        //     return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        // }

        $this->update_status($data);
        foreach ($arr as $key => $order) {
            $order_id = $order["order_id"];
            $phone = $order["phone"];
            $order_id_1 = ' '.$order["order_id"];
            // $phone = ' ' . $order["phone"];
            $order_exists = Shipment::where('bar_code', $order_id_1)->orWhere('bar_code', $order["order_id"])->first();
            if (!$order_exists) {
                // dd($order['delivery_date']);
                $order_data = new Shipment();
                $order_data->order_id = $order_id;
                $order_data->airway_bill_no = $order_id;
                $order_data->bar_code = $order_id;
                $order_data->client_name = $order["name_of_the_client"];
                // $order_data->client_address = $order["address"];
                // $order_data-> = $order["Postal Code"];
                $order_data->client_city = $order["city"];
                // $order_data-> = $order["Region"];
                $order_data->client_phone = $phone;
                $order_data->cod_amount = $order["cod_amount"];

                $order_data->user_id = Auth::id();

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
                    $order_data->status = $status;
                } else {
                    $order_data->status = 'Warehouse';
                }
                // dd($order_data->status);

                if (array_key_exists('delivery_date', $order)) {
                    // dd($order);
                    if ($order['delivery_date'] == '' || $order['delivery_date'] == null) {
                        $delivery_date = null;
                    } else {
                        $delivery_date = $order['delivery_date'];
                    }
                    $order_data->derivery_date = $delivery_date;
                }

                // $instructions = (array_key_exists('special_instructions', $order)) ? $order['special_instructions'] : $order['instructions'];
                $instructions = (array_key_exists('special_instructions', $order)) ? $order['special_instructions'] : null;

                if ($instructions) {
                    // dd($order);
                    if ($instructions == '' || $instructions == null) {
                        $instructions = null;
                    } else {
                        $instructions = $instructions;
                    }
                    $order_data->speciial_instruction = $instructions;
                }

                // if (array_key_exists('instructions', $order)) {
                //     // dd($order);
                //     if ($order['instructions'] == '' || $order['instructions'] == null) {
                //         $instructions = null;
                //     } else {
                //         $instructions = $order['instructions'];
                //     }
                //     $order_data->speciial_instruction = $instructions;
                // }
                // $order_data->client_email = $order['sender_mail'];
                $order_data->client_email = (array_key_exists('sender_mail', $order)) ? $order['sender_mail'] : $order['product_name'];

                // $order_data->client_phone = $order['phone'];
                $order_data->client_address = $order['address'];
                $order_data->client_city = (array_key_exists('city', $order)) ? $order['city'] : null;
                $order_data->amount_ordered = $order['quantity'];
                $order_data->client_region = (array_key_exists('region', $order)) ? $order['region'] : null;
                $order_data->user_id = Auth::id();
                $order_data->shipment_id = random_int(1000000, 9999999);
                $order_data->paid = 0;
                $order_data->printReceipt = 0;
                $order_data->printed = 0;
                $order_data->sender_name = $client_det->name;
                $order_data->sender_email = $client_det->email;
                $order_data->sender_phone = $client_det->phone;
                $order_data->sender_address = $client_det->address;
                $order_data->sender_city = $client_det->city;
                $order_data->client_id = $request->client;
                // $order_data->country = $order->country;
                $order_data->country_id = Auth::user()->country_id;
                $order_data->save();
            }
        }
        return redirect('/#/shipments');

}
}
