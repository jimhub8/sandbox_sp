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
    public function delivery_count()
    {
        DB::enableQueryLog(); // Enable query log
        $day = new DateTime(Carbon::today());
        $day_ = $day->format('l');
        $client = Client::where('show_on', $day_)->first();
        if ($client) {
            $start_day = $client->start_day;
            $end_day = $client->end_day;
            $today = Carbon::today();
            if ($day_ == $start_day) {
                $start_day = $today;
                $end_day = $today->modify("next " . $client->end_day);
            } else {
                $start_day = $today->modify("last " . $client->start_day);
                $end_day = $today->modify("next " . $client->end_day);
            }
        }
        // $date->nextSunday();
        $date_arr = [$start_day, $end_day];
        dd($date_arr);

        // Your Eloquent query

        return Shipment::whereBetween('delivered_on', $date_arr)->count();
        dd(DB::getQueryLog()); // Show results of log
    }
}
