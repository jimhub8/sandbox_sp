<?php

namespace App\Observers;

use App\Call;
use App\Shipment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ShipmentObserver
{
    public function updated(Shipment $shipment)
    {
        // dd($shipment);
        $original = $shipment->getOriginal();
        $dirty = $shipment->getDirty();
        $key_v = array();
        foreach ($dirty as $key => $dirt) {
            $key_v[] = $key;
        }
        $slice = Arr::only($original, $key_v);

        // dd($slice);
        if ($shipment->isDirty('status')) {
            $original_status = $shipment->getOriginal('status');
            $status = $shipment->status;
            $original_status = ($original_status == null || $original_status == '') ? 'Warehouse' : $original_status;
            $shipment_id = $shipment->id;
            $call = new Call;
            $call->user_id = Auth::id();
            $call->shipment_id = $shipment_id;
            $call->event = 'Status update';
            $call->country_id = Auth::user()->country_id;
            $call->event = $shipment->remark;
            // $shipment->event = $shipment->update_data;
            $call->save();
            // dd($shipment->event);
            // dd($shipment);
        } elseif ($shipment->update_data) {
            // dd($shipment->update_data);
            $call = new Call;
            $shipment_id = $shipment->id;
            $call->shipment_id = $shipment_id;
            $call->user_id = Auth::id();
            $call->country_id = Auth::user()->country_id;
            $call->event = 'Shipment edit';
            $original_data = serialize($slice) ;
            $update_data = serialize($shipment->getDirty()) ;
            $call->original_data = $original_data;
            $call->update_data = $update_data;
            $call->save();
        }
    }
    /*
    public function created(Shipment $shipment) {
        $shipment = new Call;
        $shipment->user_id = Auth::id();
        $shipment->shipment_id = $shipment->id;
        $shipment->save();
    }

    public function deleted(Shipment $shipment) {
        $shipment = new Call;
        $shipment->user_id = Auth::id();
        $shipment->shipment_id = $shipment->id;
        $shipment->save();
    }

    public function restored(Shipment $shipment) {
        $shipment = new Call;
        $shipment->user_id = Auth::id();
        $shipment->shipment_id = $shipment->id;
        $shipment->save();
    }
    */
}
