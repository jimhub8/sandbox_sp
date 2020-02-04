<?php

namespace App\models;

use AfricasTalking\SDK\AfricasTalking;

class Sms
{
    public function sms($phone, $message)
    {
        // dd($message);
        // $phone = '+254731090832';
        // $phone = '254711379383';
        // $username = 'sandbox'; // use 'sandbox' for development in the test environment
        // $apiKey   = '05998e3687d028994e47a6b10ad8fdc8a8fd006a32814a1daf6483b70ba0fea7'; // use your sandbox app API key for development in the test environment

        $username = 'speedball'; // use 'sandbox' for development in the test environment
        $apiKey   = '333ca5b5daab8dd53a39fc1ca3fa37230a96473fe483391a09f0160d34a0cf1a'; // Live

        // $username = 'YOUR_USERNAME'; // use 'sandbox' for development in the test environment
        // $apiKey   = 'YOUR_API_KEY'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
            'from'    => 'Speedball',
            'message' => $message
        ]);

        print_r($result);



        // $AT = new AfricasTalking($username, $apiKey);
        // // Get one of the services
        // $sms      = $AT->sms();
        // // Use the service
        // $result = $sms->send([
        //     // 'enqueue' => true,
        //     'to'      => $phone,
        //     // 'message' => $message,
        //     // 'from' => 'speedball',
        //     'message' => 'Hello',
        // ]);
        // print_r($result);
        // return;
    }


    public function verify($phone, $code)
    {
        $phone = '+254731090832';
        // $phone = '254711379383';
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '05998e3687d028994e47a6b10ad8fdc8a8fd006a32814a1daf6483b70ba0fea7'; // use your sandbox app API key for development in the test environment

        // $username = 'speedball'; // use 'sandbox' for development in the test environment
        // $apiKey   = '333ca5b5daab8dd53a39fc1ca3fa37230a96473fe483391a09f0160d34a0cf1a'; // Live

        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'enqueue' => true,
            'from'    => 'Speedball',
            'to'      => $phone,
            'message' => $code . " is your verification code. This code will expire in 15 minutes."
        ]);
        return;
        // print_r($result);
    }
}
