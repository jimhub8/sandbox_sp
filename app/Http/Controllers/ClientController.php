<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->Validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'countryList' => 'required',
            'role_id' => 'required',
        ]);
        // return $request->all();
        $user = new Client;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $user->password = $password_hash;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country_id = $request->countryList;
        $user->end_day = $request->end_day;
        $user->start_day = $request->start_day;
        $user->show_on = $request->show_on;
        $user->activation_token = str_random(60);
        $user->save();
        $create_user = $user;
        // $user->assignRole('Client');
        // $user->assignRole($request->role_id);
        // $user->givePermissionTo($request->selected);
        // $user->password_hash = $password_hash;
        // $user = $user->makeVisible('password')->toArray();
        if ($request->role_id == 'Client') {
            $this->client_api($user);
        } elseif ($request->role_id == 'Rider') {
            return $user->makeHidden('password_hash')->toArray();
        } else {
            $create_user->notify(new SignupActivate($create_user, $password));
            $this->user_api($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return Client::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->Validate($request, [
            'form.name' => 'required',
            'form.email' => 'required|email',
            'form.phone' => 'required|numeric',
        ]);
        $old_email = $client->email;
        $user = Client::find($request->form['id']);
        // $user = $user->makeVisible('password')->toArray();
        $user->name = $request->form['name'];
        $user->email = $request->form['email'];
        $user->phone = $request->form['phone'];
        $user->branch_id = $request->form['branch_id'];
        $user->address = $request->form['address'];
        $user->city = $request->form['city'];
        $user->country = $request->form['country'];
        $user->country_id = $request->form['country_id'];
        $user->save();
        foreach ($request->form['roles'] as $role) {
            $role_name = $role['name'];
        }
        $user->syncRoles($role_name);
        $user->old_email = $old_email;
        $this->clientupdate_api($user);
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function client_api($user)
    {
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/clients', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token_f(),
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }
}
