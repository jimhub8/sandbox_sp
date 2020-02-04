<?php

namespace App\models;

use App\Shipment;
use Carbon\Carbon;

class Canclelled
{
    public function updateCancelled()
    {
        // getting the dispatcher instance (needed to enable again the event observer later on)
        // disabling the events
        $today = Carbon::today();
        // $tomorrow = Carbon::tomorrow();
        $yest = Carbon::now()->subDays(1);
        $prev_month = Carbon::today()->subMonth();


        $refused = Shipment::select('id', 'bar_code')->setEagerLoads([])
            ->where(function ($query) {
                $query->where('status', 'Returned');
                $query->orWhere('status', 'Scheduled');
                $query->orWhere('status', 'Dispatched');
            })
            ->orderBy('created_at')
            ->whereDate('derivery_date', '<=', $yest)
            ->whereDate('created_at', '<=', $prev_month)
            ->get('id')->toArray();


        $cancell_status = ['Returned', 'Scheduled', 'Dispatched', 'Delivered', 'Warehouse', 'Cancelled', 'Refused'];
        // DB::enableQueryLog(); // Enable query log
        $cancelled = Shipment::select('id')->setEagerLoads([])
            ->whereDate('created_at', '<=', $prev_month)
            ->whereNotIn('status', $cancell_status)
            // ->orWhere('status', null)
            ->orderBy('created_at')
            ->get('id')->toArray();
        // dd(DB::getQueryLog()); // Show results of log

        $id_ref = array_flatten($refused);
        $id_can = array_flatten($cancelled);

        // enabling the event dispatcher
        // dd($cancelled, $refused);
        // $bar_code = Shipment::select('bar_code')->setEagerLoads([])->whereIn('id', $id_can)->get()->toArray();
        // $bar_code_ = array_flatten($bar_code);
        Shipment::whereIn('id', $id_ref)->update(['status' => 'Refused', 'refused_on' => now()]);
        Shipment::whereIn('id', $id_can)->update(['status' => 'Cancelled', 'cancelled_date' => now()]);

        // $data = Shipment::whereIn('id', $id_ref)->count();
        // $data_1 = Shipment::whereIn('id', $id_can)->count();
        // dd($data, $data_1);
        // $update_s = new Cancelled;
        // $this->update_status($bar_code_);
        return;
    }
}
