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
        $calls = Call::with('shipment')->latest()->paginate(200);
        $calls->transform(function ($call, $key) {
            // dd($call->shipment);
            // $call->shipment = unserialize($call->shipment);
            $user = User::find($call->user_id);
            if (empty($user)) {
                // dd($call);
            } else {
                $call->user_name = $user->name;
                // dd($call->user_id);
            }
            return $call;
        });
        return $calls;
    }

    public function Filterlogs(Request $request)
    {
        // return $request->all();
        $end_date = $request->form['end_date'];
        $start_date = $request->form['start_date'];
        $calls = Call::with('shipment');
        if ($end_date & $start_date) {
            $calls = $calls->whereBetween('created_at', [$start_date, $end_date]);
        }
        if ($request->client_id) {
            $calls = $calls->where('user_id', $request->client_id);
        }
        // $calls = Call::whereBetween('created_at', [$start_date, $end_date])->where('user_id', $user_id)->skip($start - 1)->take(200)->latest()->get();
        $calls = $calls->paginate(200);
        $calls->transform(function ($call, $key) {
            // dd($call->shipment);
            // $call->shipment = unserialize($call->shipment);
            $user = User::find($call->user_id);
            if (empty($user)) {
                // dd($call);
            } else {
                $call->user_name = $user->name;
                // dd($call->user_id);
            }
            return $call;
        });
        return $calls;
    }
    public function callcount()
    {
        return Call::count();
    }
}
