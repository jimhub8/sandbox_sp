<?php

namespace App\models;

use App\Shipment;
use App\ShipmentStatus;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Status_update
{

    public function updateStatus($shipment_update)
    {

        $request = $shipment_update;
        $shipment = Shipment::find($request['id']);
        // if ($shipment->status == 'Delivered') {
        //     abort(500, 'The shipment has already been Delivered');
        // }
        $this->update_status($shipment_update);
        // $this->update_status($reqst)[';']
        // return $request['all']();
        $shipment->derivery_status = $request['status'];
        $shipment->status = $request['status'];
        // var_dump($request['status']); die;
        // $shipment->remark = $request['formobg']['remark'];
        if ($request['status'] == 'Delivered') {
            $shipment->derivery_date = now();;
            $shipment->delivered_on     = now();
            // $shipment->receiver_id = ($request['formobg']['receiver_id']) ? $request['formobg']['receiver_id'] : null;
            // $shipment->receiver_name = $request['formobg']['receiver_name'];
        } elseif ($request['status'] == 'Returned') {
            $shipment->return_date = now();
            // $shipment->driver = null;
        } elseif ($request['status'] == 'Cancelled') {
            $shipment->cancelled_date = now();
            // $shipment->driver = null;
        } elseif ($request['status'] == 'Dispatched') {
            $shipment->dispatch_date = now();
        }
        $original_status = $shipment->getOriginal('status');
        $shipment->remark = 'order status updated from ' . $original_status . ' to ' .  $request['status'] . ' by ' . Auth::user()->name;
        if ($shipment->save()) {
            $shipStatus = Shipment::find($request['id']);
            $statusUpdate = new ShipmentStatus();
            $statusUpdate->remark = $request['comment'];
            $statusUpdate->status = $request['status'];
            // $statusUpdate->location = $request['formobg']['location'];
            // $statusUpdate->derivery_time = $request['formobg']['derivery_time'];
            $statusUpdate->user_id = Auth::id();
            $statusUpdate->branch_id = Auth::user()->branch_id;
            $statusUpdate->shipment_id = $request['id'];
            $statusUpdate->save();
        }
    }

    public function token_f()
    {
        // return session()->get('token.access_token');
        $token = Apimft::where('user_id', Auth::id())->first();
        if ($token) {
            return $token->access_token;
        } else {
            abort(401);
        }
    }
    public function update_status($data)
    {
        // dd($this->token_f());
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/orderStatus', [
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
        } catch (\Exception $e) {
            // dd($e);
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            // return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            // return $e->getMessage();
            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            return;
            // $arrayName = array('error' => 'Error', 'message' => $message);
            // dd($message);
            abort(422, $message);
            // return $e->getMessage();
        }
    }

}
