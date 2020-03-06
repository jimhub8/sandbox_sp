<?php

namespace App\Http\Controllers;

use App\models\ShipmentUpdate;
use App\models\Status_update;
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
        $this->Validate($request, [
            'comment' => 'required',
        ]);
        // return $request->all();
        $shipmentUpdate = new ShipmentUpdate;
        $shipmentUpdate->comment = $request->comment;
        $shipmentUpdate->delivery_status = $request->status;
        $shipmentUpdate->user_id = Auth::id();
        $shipmentUpdate->branch_id = $request->branch_id;
        $shipmentUpdate->rider_id = $request->driver;
        $shipmentUpdate->shipment_id = $request->id;
        $shipmentUpdate->country_id = Auth::user()->country_id;
        $shipmentUpdate->save();
        $ship_status = new Status_update;
        $ship_status->updateStatus($request->all());
    }

    public function Waybill_search($search)
    {
        $shipments = Shipment::setEagerLoads([])->where('bar_code', $search)->get();
        $shipments = $shipments->transform(function ($shipment) {
            $shipment->driver = ($shipment->driver) ? (int) $shipment->driver : null;
            return $shipment;
        });
        if (count($shipments) > 0) {
            return response()->json(['status' => true, 'shipment' => $shipments[0]]);
        }
        return response()->json(['status' => false]);
    }


    public function transform_shipment($shipments)
    {
        $shipments->transform(function ($shipment) {
            // dd($shipment->branch->branch_name);
            $shipment->created_by = ($shipment->user) ? $shipment->user->name : null;
            $shipment->bar_code = ($shipment->shipment) ? $shipment->shipment->bar_code : null;
            $shipment->rider_name = ($shipment->rider) ? $shipment->rider->name : null;
            $shipment->branch_name = ($shipment->branch) ? $shipment->branch->branch_name : null;
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
        if ($request->country_id) {
            $shipmentUpdates = $shipmentUpdates->where('country_id', $request->country_id);
        } else {
            $shipmentUpdates = $shipmentUpdates->where('country_id', Auth::user()->country_id);
        }
        $shipmentUpdates = $shipmentUpdates->paginate(300);
        return $this->transform_shipment($shipmentUpdates);
    }
}
