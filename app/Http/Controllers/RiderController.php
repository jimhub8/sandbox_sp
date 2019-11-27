<?php

namespace App\Http\Controllers;

use App\models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('Admin')) {
            return Rider::paginate(1000);
        } else {
            return Rider::where('country_id', Auth::user()->country_id)->paginate(1000);
        }
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
            // 'role_id' => 'required',
        ]);
        // return $request->all();
        $user = new Rider;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $user->password = $password_hash;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country_id = ($request->countryList) ? $request->countryList : Auth::user()->country_id;
        $user->save();
        return;
        //     if ($request->role_id == 'Client') {
        //     $this->client_api($user);
        // } elseif ($request->role_id == 'Rider') {
        //     return $user->makeHidden('password_hash')->toArray();
        // } else {
        //     $create_user->notify(new SignupActivate($create_user, $password));
        //     $this->user_api($user);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Rider::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->Validate($request, [
        //     'form.name' => 'required',
        //     'form.email' => 'required|email',
        //     'form.phone' => 'required|numeric',
        // ]);
        // return $request->all();
        $user = Rider::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country_id = $request->countryList;
        $user->save();
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rider::find($id)->delete();
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

    public function searchRider($search)
    {
        return Rider::where('name', 'LIKE', "%{$search}%")->get();
    }
}
