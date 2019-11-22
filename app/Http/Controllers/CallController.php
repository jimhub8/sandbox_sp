<?php

namespace App\Http\Controllers;

use App\Call;
use App\User;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calls = Call::with('shipment', 'user')->latest()->paginate(200);
        $calls->transform(function ($call, $key) {
            // dd($call->shipment);
            // $call->shipment = unserialize($call->shipment);
            $call->user_name = $call->user->name;
            return $call;
        });
        return $calls;
    }

    public function Filterlogs(Request $request)
    {
        // return $request->all();
        $end_date = $request->end_date;
        $start_date = $request->start_date;
        $calls = Call::latest()->with('shipment', 'user');
        if ($end_date & $start_date) {
            $calls = $calls->whereBetween('created_at', [$start_date, $end_date]);
        }
        if ($request->client_id) {
            $calls = $calls->where('user_id', $request->client_id);
        }
        $calls = $calls->paginate(200);
        $calls->transform(function ($call, $key) {
            // dd($call->shipment);
            // $call->shipment = unserialize($call->shipment);
            $call->user_name = $call->user->name;
            return $call;
        });
        return $calls;
    }
    public function callcount()
    {
        return Call::count();
    }
}
