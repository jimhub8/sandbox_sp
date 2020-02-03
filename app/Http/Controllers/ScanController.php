<?php

namespace App\Http\Controllers;

use App\Shipment;
use App\ShipmentStatus;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\models\Apimft;

// use Illuminate\Support\Carbon;

class ScanController extends Controller
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
    // Out Scan
    public function barcodeUpdate(Request $request, Shipment $shipment, $bar_code = null)
    {
        // return $request->all();
        $bar_code = str_replace("-", "", $request->bar_code_out);
        $bar_code = trim($request->bar_code_out);
        $barcode = Shipment::latest()->where('bar_code', 'LIKE', "%{$bar_code}%")->take(5)->get();
        // $barcode = Shipment::where('bar_code', 'LIKE', "%{$bar_code}%")->first();
        if (count($barcode) > 0) {
            return $barcode;
        } else {
            return response()->json(['errors' => 'errors']);
        }
    }
    // In Scan
    public function barcodeIn(Request $request, Shipment $shipment, $bar_code_in = null)
    {
        $bar_code = str_replace("-", "", $request->bar_code_in);
        $bar_code = trim($request->bar_code_in);
        // dd($barcode);
        $barcode = Shipment::latest()->where('bar_code', 'LIKE', "%{$bar_code}%")->take(5)->get();
        if ($barcode) {
            return $barcode;
        } else {
            return response()->json(['errors' => 'errors']);
        }
    }
    public function update_status($data)
    {
        $token = $this->token_f();
        $url = env('API_URL') . '/api/orderScan';
        try {
            $client = new Client;
            $request = $client->request('POST', $url, [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $data,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            $message = $e->getResponse()->getBody();
            // return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
        }
    }

    public function statusUpdate(Request $request)
    {
        // return $request->all();
        $this->update_status($request->all());
        // $request->all()
        // $this->validate($request, [
        //     'form.status_out' => 'required',
        //     'form.rider_out' => 'required',

        // ]);
        $id = [];
        foreach ($request->scan as $selectedItems) {
            $id[] = $selectedItems['id'];
        }
        // return $id;
        $status = $request->form['status_out'];
        // $derivery_time = $request->derivery_time;
        $remark = $request->form['remarks_out'];
        $rider_out = $request->form['rider_out'];
        $location = $request->form['location_out'];
        $assign_date = date("Y-m-d");
        $scan_date_out = $request->form['scan_date_out'];
        // dd($assign_date);
        // $shipment = Shipment::whereIn('id', $id)->update(['status' => $status, 'remark' => $remark, 'driver' => $rider_out, 'assign_date' => $assign_date, 'derivery_date' => $scan_date_out]);
        foreach ($id as $value) {

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
                        'data' => $request->all(),
                    ])
                ]);
                $shipment = Shipment::find($value);
                $shipment->status = $status;
                $shipment->remark = $remark;
                $shipment->driver = $rider_out;
                $shipment->assign_date = $assign_date;
                $shipment->dispatch_date = now();
                $shipment->save();
            } catch (\Exception $e) {
                \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
                $code = $e->getResponse()->getStatusCode();
                if ($code == 401) {
                    abort(401);
                }
                return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            }
        }

        $shipStatus = Shipment::whereIn('id', $id)->get();
        foreach ($shipStatus as $statuses) {
            $statusUpdate = new ShipmentStatus;
            $statusUpdate->remark = $remark;
            $statusUpdate->status = $status;
            $statusUpdate->location = $location;
            // $statusUpdate->derivery_time = $request->derivery_time;
            $statusUpdate->user_id = Auth::id();
            $statusUpdate->branch_id = Auth::user()->branch_id;
            $statusUpdate->shipment_id = $statuses->id;
            // return $statusUpdate;
            $statusUpdate->save();
            // return $statusUpdate;
        }
    }

    public function statusUpdateIn(Request $request)
    {
        // return $request->all();
        $status = (array_key_exists('status_in', $request->form)) ? $request->form['status_in'] : $request->form['status_out'];
        $url = env('API_URL') . '/api/orderScan';
        // try {
        //     $client = new Client;
        //     $request = $client->request('POST', $url, [
        //         'headers' => [
        //             'Content-type' => 'application/json',
        //             'Accept' => 'application/json',
        //             'Authorization' => 'Bearer ' . $this->token_f(),
        //         ],
        //         'body' => json_encode([
        //             'data' => $request->all(),
        //         ])
        //     ]);
        //     return $response = $request->getBody()->getContents();
        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
        //     $message = $e->getResponse()->getBody();
        //     // return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        //     $code = $e->getResponse()->getStatusCode();
        //     if ($code == 401) {
        //         abort(401);
        //     }
        //     abort(422, $message);
        // }
        // return $status;
        if (array_key_exists('rider_out', $request->form)) {
        $rider_out = $request->form['rider_out'];
        }
        // $this->update_status($request->all());
        // $this->validate($request, [
        //     'form.status_in' => 'required',
        //     'form.branch_id' => 'required',
        // ]);
        $assign_date = date("Y-m-d");
        $id = [];
        foreach ($request->scan as $selectedItems) {
            $id[] = $selectedItems['id'];
        }
        // return $id;
        // $status = $request->form['status_in'];
        // $derivery_time = $request->derivery_time;
        $remark = (array_key_exists('remarks_in', $request->form)) ? $request->form['remarks_in'] :  $request->form['remarks_out'];
        if (array_key_exists('branch_id', $request->form)) {
            $branch_id = $request->form['branch_id'];
        }
        // $location = $request->form['location_in'];
        $dispatch_date = null;
        if ($status == 'Dispatched') {
            $dispatch_date = now();
        }

        // $derivery_date = $request->scheduled_date;
        // $shipment = Shipment::whereIn('id', $id)->update(['status' => $status, 'remark' => $remark]);
        // $shipment = Shipment::whereIn('id', $id)->update(['status' => $status, 'dispatch_date' => $dispatch_date, 'branch_id' => $branch_id]);

        foreach ($id as $value) {
            $shipment = Shipment::find($value);
                $shipment->assign_date = $assign_date;
                $shipment->status = $status;
            $shipment->dispatch_date = $dispatch_date;
            if (array_key_exists('branch_id', $request->form)) {
                $shipment->branch_id = $branch_id;
            }
            if (array_key_exists('rider_out', $request->form)) {
                $shipment->driver = $rider_out;
            }
            $shipment->save();
            // ->update(['status' => $status, 'dispatch_date' => $dispatch_date, 'branch_id' => $branch_id]);

        }

        $shipStatus = Shipment::whereIn('id', $id)->get();
        foreach ($shipStatus as $statuses) {
            $statusUpdate = new ShipmentStatus;
            $statusUpdate->remark = $remark;
            $statusUpdate->status = $status;
            // $statusUpdate->location = $location;
            // $statusUpdate->derivery_time = $request->derivery_time;
            $statusUpdate->user_id = Auth::id();
            $statusUpdate->branch_id = Auth::user()->branch_id;
            $statusUpdate->shipment_id = $statuses->id;
            // return $statusUpdate;
            $statusUpdate->save();
            // return $statusUpdate;
        }

        // $sms = new Sms;
        // if ($status == 'Not picking') {
        //     foreach ($shipStatus as $phone) {
        //         $no = $phone->client_phone;
        //         $no_A = explode(' ', $no);
        //         $phone_no = $no_A[0];
        //         $sms->send_sms($phone_no, 'Dear ' . $phone->client_name . ', we tried calling you but you were not available  Incase of queries call +254207608777, +254207608778, +254207608779   ');
        //     }
        // } elseif ($status == 'Not available') {
        //     foreach ($shipStatus as $phone) {
        //         $no = $phone->client_phone;
        //         $no_A = explode(' ', $no);
        //         $phone_no = $no_A[0];
        //         $sms->send_sms($phone_no, 'Dear ' . $phone->client_name . ', we tried calling you but you were not available  Incase of queries call +254207608777, +254207608778, +254207608779   ');
        //     }
        // } elseif ($status == 'Delivered') {
        //     foreach ($shipStatus as $phone) {
        //         $no = $phone->client_phone;
        //         $no_A = explode(' ', $no);
        //         $phone_no = $no_A[0];
        //         $sms->send_sms($phone_no, 'Dear ' . $phone->client_name . ', Your shipment (waybill number: ' . $phone->bar_code . ') has been delivered  Incase of queries call +254207608777, +254207608778, +254207608779    ');
        //     }
        // } elseif ($status == 'Dispatched') {
        //     foreach ($shipStatus as $phone) {
        //         $no = $phone->client_phone;
        //         $no_A = explode(' ', $no);
        //         $phone_no = $no_A[0];
        //         $sms->send_sms($phone_no, 'Dear ' . $phone->client_name . ', Your shipment (waybill number: ' . $phone->bar_code . ') has been dispatched to ' . $phone->client_city . '  Incase of queries call +254207608777, +254207608778, +254207608779    ');
        //     }
        // }
        // $shipStatus->statuses()->saveMany($shipStatus);
        return $shipment;
    }


    public function filterR(Request $request)
    {
        $driver = $request->selectRider['id'];
        // return $driver;
        $start_date = $request->form['start_date'];
        $end_date = $request->form['end_date'];
        return Shipment::where('driver', $driver)->where('status', '!=', 'Returned')->whereBetween('assign_date', [$start_date, $end_date])->take(500)->latest()->get();
    }

    public function getDelScan(Request $request)
    {
        $driver = $request->selectRider['id'];
        $start_date = $request->form['start_date'];
        $end_date = $request->form['end_date'];
        return Shipment::where('driver', $driver)->where('status', 'Delivered')->whereBetween('assign_date', [$start_date, $end_date])->take(500)->latest()->count();
    }

    public function getNotDelScan(Request $request)
    {
        $driver = $request->selectRider['id'];
        $start_date = $request->form['start_date'];
        $end_date = $request->form['end_date'];
        return Shipment::where('driver', $driver)->where('status', '!=', 'Delivered')->whereBetween('assign_date', [$start_date, $end_date])->take(500)->latest()->count();
    }

    public function send_sms($phone, $message)
    {
        return $phone;
        // dd($phone . '   ' . $message);
        // $phone = '254778301465';
        $phone = '254731090832';
        // $phone = '254706920275';
        $sms = $message;
        $senderID = 'SPEEDBALL';

        $login = 'SPEEDBALL';
        $password = 's12345';

        $clientsmsID = rand(1000, 9999);

        $xml_data = '<?xml version="1.0"?><smslist><sms><user>' . $login . '</user><password>' . $password . '</password><message>' . $sms . '</message><mobiles>' . $phone . '</mobiles><senderid>' . $senderID . '</senderid><clientsmsid>' . $clientsmsID . '</clientsmsid></sms></smslist>';

        $URL = "http://messaging.advantasms.com/bulksms/sendsms.jsp?";

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $phone;
    }

    public function dispatch_scanner($search)
    {

    }
    public function filter_rider(Request $request)
    {
        // return $request->all();
        $start_date = Carbon::today();
        $end_date = Carbon::tomorrow();
        return Shipment::setEagerLoads([])->whereBetween('assign_date', [$start_date, $end_date])->where('driver', $request->rider_out)->get();
    }
}
