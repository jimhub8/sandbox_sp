<?php

namespace App\Http\Controllers;

use App\Client;
use App\Shipment;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{
    public function screen()
    {
        return view('screen.screen');
    }

    public function get_data()
    {
        // DB::enableQueryLog(); // Enable query log
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // Your Eloquent query

        $total = Shipment::whereBetween('created_at', $date_arr)->where('client_id', $client->id)->count();
        $delivered = Shipment::whereBetween('derivery_date', $date_arr)->where('status', 'Delivered')->where('client_id', $client->id)->count();
        $data = array('total' => $total, 'delivered' => $delivered, 'client' => $client);
        // dd(DB::getQueryLog()); // Show results of log
        return $data;
    }

    public function get_filter_data($id)
    {
        // DB::enableQueryLog(); // Enable query log
        $details_fun = $this->details_filter_fun($id);
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // Your Eloquent query

        $total = Shipment::whereBetween('created_at', $date_arr)->where('client_id', $client->id)->count();
        $delivered = Shipment::whereBetween('derivery_date', $date_arr)->where('status', 'Delivered')->where('client_id', $client->id)->count();
        $data = array('total' => $total, 'delivered' => $delivered, 'client' => $client);
        // dd(DB::getQueryLog()); // Show results of log
        return $data;
    }

    public function screen_chart()
    {
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // dd($date_arr);
        $shipments = Shipment::select(DB::raw('count(id) as count, date_format(derivery_date, "%W") as date'))
                ->orderBy('derivery_date', 'asc')
                ->groupBy('date')
                ->where('status', 'Delivered')
                ->where('client_id', $client->id)
                ->whereBetween('derivery_date', $date_arr)
                ->get();
        $lables = [];
        $rows = [];
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


    public function screen_filter_chart($id)
    {
        $details_fun = $this->details_filter_fun($id);
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // dd($date_arr);
        $shipments = Shipment::select(DB::raw('count(id) as count, date_format(derivery_date, "%W") as date'))
                ->orderBy('derivery_date', 'asc')
                ->groupBy('date')
                ->where('status', 'Delivered')
                ->where('client_id', $client->id)
                ->whereBetween('derivery_date', $date_arr)
                ->get();
        $lables = [];
        $rows = [];
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
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today()->modify("next " . $client->end_day);
            } else {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today();
            }
        } else {
            return;
        }
        $date_arr = [];
        $count = 0;
        foreach ($start_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        $count = 0;
        foreach ($end_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        return ['client' => $client, 'date_arr' => $date_arr];
    }


    public function details_filter_fun($id)
    {
        $day = new DateTime(Carbon::today());
        $day_ = $day->format('l');
        // dd($day_);
        $client = Client::find($id);
        if ($client) {
            $start_day = $client->start_day;
            $end_day = $client->end_day;
            $today = Carbon::today();
            if ($day_ == $start_day) {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today()->modify("next " . $client->end_day);
            } else {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today();
            }
        } else {
            return;
        }
        $date_arr = [];
        $count = 0;
        foreach ($start_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        $count = 0;
        foreach ($end_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        return ['client' => $client, 'date_arr' => $date_arr];
    }



    // Screen 2

    public function get_data_1()
    {
        // DB::enableQueryLog(); // Enable query log
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // Your Eloquent query

        $total = Shipment::whereBetween('created_at', $date_arr)->where('client_id', $client->id)->count();
        $delivered = Shipment::whereBetween('created_at', $date_arr)->where('status', 'Delivered')->where('client_id', $client->id)->count();
        $data = array('total' => $total, 'delivered' => $delivered, 'client' => $client);
        // dd(DB::getQueryLog()); // Show results of log
        return $data;
    }

    public function get_filter_data_1($id)
    {
        // DB::enableQueryLog(); // Enable query log
        $details_fun = $this->details_filter_fun($id);
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // Your Eloquent query

        $total = Shipment::whereBetween('created_at', $date_arr)->where('client_id', $client->id)->count();
        $delivered = Shipment::whereBetween('created_at', $date_arr)->where('status', 'Delivered')->where('client_id', $client->id)->count();
        $data = array('total' => $total, 'delivered' => $delivered, 'client' => $client);
        // dd(DB::getQueryLog()); // Show results of log
        return $data;
    }

    public function screen_chart_1()
    {
        $details_fun = $this->details_fun();
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // dd($date_arr);
        $shipments = Shipment::select(DB::raw('count(id) as count, date_format(created_at, "%W") as date'))
                ->orderBy('created_at', 'asc')
                ->groupBy('date')
                ->where('status', 'Delivered')
                ->where('client_id', $client->id)
                ->whereBetween('created_at', $date_arr)
                ->get();
        $lables = [];
        $rows = [];
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

    public function screen_filter_chart_1($id)
    {
        $details_fun = $this->details_filter_fun($id);
        $client = $details_fun['client'];
        $date_arr = $details_fun['date_arr'];
        // dd($date_arr);
        $shipments = Shipment::select(DB::raw('count(id) as count, date_format(created_at, "%W") as date'))
                ->orderBy('created_at', 'asc')
                ->groupBy('date')
                ->where('status', 'Delivered')
                ->where('client_id', $client->id)
                ->whereBetween('created_at', $date_arr)
                ->get();
        $lables = [];
        $rows = [];
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

    public function details_fun_1()
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
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today()->modify("next " . $client->end_day);
            } else {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today();
            }
        } else {
            return;
        }
        $date_arr = [];
        $count = 0;
        foreach ($start_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        $count = 0;
        foreach ($end_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        return ['client' => $client, 'date_arr' => $date_arr];
    }


    public function details_filter_fun_1($id)
    {
        $day = new DateTime(Carbon::today());
        $day_ = $day->format('l');
        // dd($day_);
        $client = Client::find($id);
        if ($client) {
            $start_day = $client->start_day;
            $end_day = $client->end_day;
            $today = Carbon::today();
            if ($day_ == $start_day) {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today()->modify("next " . $client->end_day);
            } else {
                $start_day_ = Carbon::today()->modify("last " . $client->start_day);
                $end_day_ = Carbon::today();
            }
        } else {
            return;
        }
        $date_arr = [];
        $count = 0;
        foreach ($start_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        $count = 0;
        foreach ($end_day_ as $data) {
            if ($count < 1) {
                $count++;
                $date_arr[] = $data;
            }
        }
        return ['client' => $client, 'date_arr' => $date_arr];
    }
}
