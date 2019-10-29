<?php

namespace App;

use GuzzleHttp\Client;

class Cancelled
{
    public function token_f()
    {
        return session()->get('token.access_token');
    }
    public function update_status($data)
    {

        try {
            // return ($bar_code_);
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/updateCancelled', [
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
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            // return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
            // return $e->getMessage();
            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            // dd($message);
            return;
            abort(422, $message);
            // return $e->getMessage();
        }
    }
}
