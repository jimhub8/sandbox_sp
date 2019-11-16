<?php

namespace App\Http\Controllers;

use App\Client;
use App\Shipment;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{
    public function details_fun()
    {
        $day = new DateTime(Carbon::today());
        $day_ = $day->format('l');
        // dd($day_);
        $client = Client::where('show_on', $day_)->first();
        if ($client) {
            $start_day = $client->start_day;
            $end_day = $client->end_day;
            $today = Carbon::today();
            if ($day_ == $start_day) {
                $start_day_ = Carbon::today();
                $end_day_ = $today->modify("next " . $client->end_day);
            } else {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today()->modify("next " . $client->end_day);
            }
            // dd($start_day_);
        } else {
            return;
        }
        // $date->nextSunday();
        // dd($start_day['date']);
        $date_arr = [];
        $count = 0;
        foreach ($start_day_ as $data) {
            // $start_date = $data;
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        // dd($start_day_, $end_day_);
        $count = 0;
        foreach ($end_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        return ['client' => $client, 'date_arr' => $date_arr];
    }
    public function screen()
    {
        DB::enableQueryLog(); // Enable query log
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // dd($date_arr, $client);
        //     $date_arr = [$start_date, $end_date];
        // dd($start_date);
        // Your Eloquent query

        $total = Shipment::whereBetween('created_at', $date_arr)->where('client_id', $client->id)->count();
        $delivered = Shipment::whereBetween('created_at', $date_arr)->where('status', 'Delivered')->where('client_id', $client->id)->count();
        // dd(DB::getQueryLog()); // Show results of log
        return view('screen.screen', compact('delivered', 'client', 'total'));
    }

    public function screen_chart()
    {
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        $shipments = Shipment::select(DB::raw('count(id) as count, date_format(created_at, "%W") as date'))
                ->orderBy('id', 'asc')
                ->groupBy('date')
                ->where('client_id', $client->id)
                ->whereBetween('created_at', $date_arr)
                // ->where('branch_id', Auth::id())
                ->get();

        $lables = [];
        $rows = [];
        // dd($shipments);
        foreach ($shipments as $key => $shipment) {
            $lables[] = $shipment->date;
            $rows[] = $shipment->count;
        }
        $data = array(
            'lables' => $lables,
            'rows' => $rows
        );
        return response()->json(['data' => $data]);
    }


}
