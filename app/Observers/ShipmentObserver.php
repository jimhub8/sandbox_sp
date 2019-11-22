<?php

namespace App\Observers;

use App\Call;
use App\Shipment;
use Illuminate\Support\Facades\Auth;

class ShipmentObserver
{
    public function updated(Shipment $shipment)
    {
        // dd($shipment->getOriginal('status'));
        if ($shipment->isDirty('status')) {
            $original_status = $shipment->getOriginal('status');
            $status = $shipment->status;
            $original_status = ($original_status == null || $original_status == '') ? 'Warehouse' : $original_status ;
            $shipment_id = $shipment->id;
            $shipment = new Call;
            $shipment->user_id = Auth::id();
            $shipment->shipment_id = $shipment_id;
            $shipment->event = 'order status updated from ' . $original_status . ' to ' .  $status . ' by ' . Auth::user()->name;
            // dd($shipment->event);
            $shipment->save();
            // dd($shipment);
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
