<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function send_sms(Request $request)
    {
        // return ($request->all());
        $message = $request->message;
        $shipments = $request->shipments;
        // return $phone;
        // // dd($phone . '   ' . $message);
        // // $phone = '254778301465';
        foreach ($shipments as $shipment) {
            // $phone = $shipment['client_phone'];
            // $phone = preg_replace('/[^A-Za-z0-9\-]/', '', $phone); // Removes special chars.
            // dd($phone);
            $phone = '254731090832';
            // $phone = '254706920275';
            $sms = 'Dear '. $shipment['client_name'] . ' ' . $message;
            $senderID = 'SPEEDBALL';
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
            return $output;
        }
    }
}
