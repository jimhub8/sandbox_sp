<?php

namespace App\Http\Controllers;

use App\models\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function send_sms(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $status = $request->status;
        // return ($request->all());
        // $message = $request->message;
        $shipments = $request->shipments;
        foreach ($shipments as $shipment) {
            $phone = $shipment['client_phone'];
            // $phone = str_replace(' ', '', $phone);

            $phone = preg_replace('/[^A-Za-z0-9\-]/', '', $phone);
             $start_no = ((substr($phone, 0, 1)));
             if ($start_no == 2) {
                $phone = ((substr($phone, 0, 12)));
             } elseif($start_no == 0) {
                $phone = ((substr($phone, 0, 10)));
             } elseif($start_no == 7) {
                $phone = +254 . ((substr($phone, 0, 9)));
             } else {
                $phone = $phone;
             }
            //  dd($phone);
            if ($status == 'Returns') {
                $sms = 'Dear ' . $shipment['client_name'] . ', we made an attempt to deliver your parcel for ' .  $shipment['client_email'] . ' but the delivery was not successful. We would like to make another delivery attempt. Kindly call or text us 0799870144/0799869844 or text 0778301465 to schedule for delivery ' .
                    ' regards. ';
            } elseif ($status == 'Not picking') {
                $sms = 'Dear ' . $shipment['client_name'] . ', we have received your parcel for ' .  $shipment['client_email'] . ' that you ordered online. Kindly call 0799870144/0799869844 to let us know when to make the delivery' . "\n" .
                    ' regards. ' . "\n" . ' ';
            } else {
                $message = $request->message;
                $sms = 'Dear ' . $shipment['client_name'] . ', ' . $message;
            }

            $africas_talking = new Sms();
            $africas_talking->sms($phone, $sms);


            // return $sms;
            /*$senderID = 'SPEEDBALL';
            $login = 'SPEEDBALL';
            $password = 'sp33dbal';

            $clientsmsID = rand(1000, 9999);

            $xml_data = '<?xml version="1.0"?>
            <smslist>
                <sms>
                    <user>' . $login . '</user>
                    <password>' . $password . '</password>
                    <message>' . $sms . '</message>
                    <mobiles>' . $phone . '</mobiles>
                    <senderid>' . $senderID . '</senderid>
                    <clientsmsid>' . $clientsmsID . '</clientsmsid>
                </sms>
            </smslist>';

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
            // return $output; */
        }
        return;
    }
}
