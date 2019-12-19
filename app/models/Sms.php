<?php

namespace App\models;

use AfricasTalking\SDK\AfricasTalking;

class Sms
{
    public function sms($phone, $message)
    {
        // dd($message);
        $phone = '+254731090832';
        // $phone = '254711379383';
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '05998e3687d028994e47a6b10ad8fdc8a8fd006a32814a1daf6483b70ba0fea7'; // use your sandbox app API key for development in the test environment

        // $username = 'speedball'; // use 'sandbox' for development in the test environment
        // $apiKey   = '333ca5b5daab8dd53a39fc1ca3fa37230a96473fe483391a09f0160d34a0cf1a'; // Live

        // $username = 'YOUR_USERNAME'; // use 'sandbox' for development in the test environment
        // $apiKey   = 'YOUR_API_KEY'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
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

    public function birthday($phone, $policy)
    {
        // $username = 'willow'; // use 'sandbox' for development in the test environment
        // $apiKey   = 'ef0c4a1d3d2b347d2c7d173fb61b3841735bf523e1bbeda938508d782cf20153'; // Live

        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '2fd972d459061d98697de4170eef1bb5137d8f7a6d1c7e3c6a2a924cecacf203'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service

        $result   = $sms->send([
            'to'      => $phone,
            'message' => "Dear " . $policy->name . ", here is to a happy birthday. We wish you many more. Enjoy your day",
            // 'message' => 'Hello',
        ]);
        // print_r($result);
        return;
    }
    public function message($data, $message)
    {
        // $username = 'willow'; // Live
        // $apiKey   = 'ef0c4a1d3d2b347d2c7d173fb61b3841735bf523e1bbeda938508d782cf20153'; // Live


        $apiKey   = 'b3b4f2cc4b86fd1395e5ed430978de9f536dd7756d0e4594a8f28482255e4557'; // use your sandbox app API key for development in the test environment
        $username = 'sandbox'; // use 'sandbox' for development in the test environment

        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'enqueue' => true,
            // 'from'    => 'willow',
            'to'      => $data['phone'],
            'message' => "Dear " . $data['name'] . ' . ' . $message,
            // 'message' => "Dear " . $data['name'] . ' <br /> ' . $message,
            // 'message' => 'Hello',
        ]);
        return;
        // print_r($result);
    }
}
