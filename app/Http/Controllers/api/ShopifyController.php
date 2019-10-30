<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shipment;
use App\User;
   
class ShopifyController extends Controller
{
    public function shopify_orders(Request $request)
    {
        $orders = $request->data;
        // dd($orders);
        foreach ($orders as $order) {
            // dd($order['order_no']);
            $order_data = new Shipment();
            $order_data->order_id = (array_key_exists('order_no', $order)) ? $order['order_no'] : null;
            $order_data->airway_bill_no = (array_key_exists('order_no', $order)) ? $order['order_no'] : null;
            $order_data->bar_code = (array_key_exists('order_no', $order)) ? $order['order_no'] : null;
            $order_data->client_name = (array_key_exists('client_name', $order)) ? $order['client_name'] : null;
            $order_data->client_address = (array_key_exists('client_address', $order)) ? $order['client_address'] : null;
            $order_data->client_city = (array_key_exists('client_city', $order)) ? $order['client_city'] : null;
            $order_data->country = (array_key_exists('client_country', $order)) ? $order['client_country'] : null;
            $order_data->client_phone = (array_key_exists('client_phone', $order)) ? $order['client_phone'] : null;
            $order_data->client_email = (array_key_exists('sender_email', $order)) ? $order['sender_email'] : null;
            $order_data->cod_amount = (array_key_exists('amount', $order)) ? $order['amount'] : null;
            $order_data->user_id = (array_key_exists('user_id', $order)) ? $order['user_id'] : null;
            $order_data->speciial_instruction = (array_key_exists('notes', $order)) ? $order['notes'] : null;
            $order_data->amount_ordered = (array_key_exists('quantity', $order)) ? $order['quantity'] : null;
            $order_data->client_id = 194;
            //    $order_data->client_email = (array_key_exists('sender_email', $order)) ? $order['sender_email'] : null;
            $order_data->country_id = 1;
            $order_data->printed = 0;
            $client_det = User::find(1);
            // dd($client_det);


            $order_data->sender_name = $client_det->name;
            $order_data->sender_email = $client_det->email;
            $order_data->sender_phone = $client_det->phone;
            $order_data->sender_address = $client_det->address;
            $order_data->sender_city = $client_det->city;

            $order_data->save();
        }
        return 'sccess';
    }
}
