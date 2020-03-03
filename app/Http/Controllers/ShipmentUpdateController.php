<?php

namespace App\Http\Controllers;

use App\models\ShipmentUpdate;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipmentUpdates =  ShipmentUpdate::paginate(1);
        return $this->transform_shipment($shipmentUpdates);
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
        $shipmentUpdate = new ShipmentUpdate;
        $shipmentUpdate->comment = $request->comment;
        $shipmentUpdate->delivery_status = $request->status;
        $shipmentUpdate->user_id = Auth::id();
        $shipmentUpdate->branch_id = $request->branch_id;
        $shipmentUpdate->rider_id = $request->driver;
        $shipmentUpdate->shipment_id = $request->id;
        $shipmentUpdate->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\ShipmentUpdate  $shipmentUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(ShipmentUpdate $shipmentUpdate)
    {
        //
    }

    public function Waybill_search($search)
    {
        $shipment = Shipment::select('id', 'driver', 'branch_id', 'status', 'bar_code')->setEagerLoads([])->where('bar_code', $search)->first();
        if ($shipment) {
            return response()->json(['status' => true, 'shipment' => $shipment]);
        }
        return response()->json(['status' => false]);
    }


    public function transform_shipment($shipments)
    {
        $shipments->transform(function ($shipment) {
            $shipment->created_by = $shipment->user->name;
            $shipment->bar_code = $shipment->shipment->bar_code;
            return $shipment;
        });
        return $shipments;
    }

    public function filter_updates(Request $request)
    {
        $shipmentUpdates =  new ShipmentUpdate;
        if ($request->rider_id) {
            $shipmentUpdates = $shipmentUpdates->where('rider_id', $request->rider_id);
        }
        if ($request->branch_id) {
            $shipmentUpdates = $shipmentUpdates->where('branch_id', $request->branch_id);
        }
        if ($request->status) {
            $shipmentUpdates = $shipmentUpdates->where('delivery_status', $request->status);
        }
        $shipmentUpdates = $shipmentUpdates->paginate(300);
        return $this->transform_shipment($shipmentUpdates);
    }
}
