<?php

namespace App\Http\Controllers;

use App\Scopes\ShipmentScope;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Maatwebsite\Excel\Exporter;
// use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function branchesExpo(Request $request)
    {
        // return $request->all();
        $date_array = array(
            'start_date' => $request->branch['start_date'],
            'end_date' => $request->branch['end_date'],
        );
        if ($request->branch_status != [] && $request->branch == []) {
            $status = $request->branch_status['status'];
            return Shipment::where('country_id', Auth::user()->country_id)->setEagerLoads([])->whereBetween('dispatch_date', [$date_array])->where('status', $status)->take(15000)->latest()->get();
        } elseif ($request->branch_status == [] && $request->branch != []) {
            $branch_id = $request->branch['branch_id'];
            $branch_id = $request->branch_status['branch_id'];
            return Shipment::where('country_id', Auth::user()->country_id)->setEagerLoads([])->whereBetween('dispatch_date', [$date_array])->where('branch_id', $branch_id)->take(15000)->latest()->get();
        } elseif ($request->branch_status != [] && $request->branch != []) {
            $branch_id = $request->branch['branch_id'];
            $status = $request->branch_status['status'];
            return Shipment::where('country_id', Auth::user()->country_id)->setEagerLoads([])->whereBetween('dispatch_date', [$date_array])->where('status', $status)->where('branch_id', $branch_id)->take(15000)->latest()->get();
        } else {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->take(15000)->where('branch_id', $request->branch['branch_id'])->where('status', $status)->get();
        }

        // return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->take(15000)->where('branch_id', $request->branch['branch_id'])->where('status', $status)->get();
    }


    public function displayReport(Request $request)
    {
        // dd($request->all());
        $date_array = array(
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        );
        $status = $request->status;
        return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->take(15000)->where('status', $status)->get();
    }
    public function DriverReport(Request $request)
    {
        $shipments = Shipment::setEagerLoads([]);
        if ($request->start_date && $request->end_date) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $date_array = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
            $shipments = $shipments->whereBetween('created_at', $date_array);
        }
        if (!empty($request->rinder_id)) {
            $shipments = $shipments->whereIn('driver', $request->rinder_id);
        }
        return $shipments->latest()->take(20000)->get();
    }

    public function userDateExpo(Request $request)
    {
        $shipments = Shipment::setEagerLoads([]);
        if ($request->start_date && $request->end_date) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $date_array = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
            $shipments = $shipments->whereBetween('created_at', $date_array);
        }
        if (!empty($request->client)) {
            $client = $request->client;
            $shipments = $shipments->whereIn('client_id', $client);
        }
        return $shipments->latest()->take(20000)->get();
        // return Shipment::where('country_id', Auth::user()->country_id)->latest()->where('client_id', $request->client_id)->setEagerLoads([])->whereBetween('created_at', [$date_array])->take(15000)->get();
    }

    public function DelivReport(Request $request)
    {
        // return $request->all();
        if (!$request->start_date || !$request->end_date || !$request->status) {
            // abort(422);
            $this->Validate($request, [
                'status' => 'required',
                'end_date' => 'required',
                'start_date' => 'required',
            ]);
        }

        // return $request->all();
        $status = $request->status;
        $branch_id = $request->branch_id;
        $client = $request->client;
        $shipments = Shipment::setEagerLoads([]);
        if (Auth::user()->hasPermissionTo('filter by country') && $request->country) {
            $shipments = $shipments->withoutGlobalScope(ShipmentScope::class);
        }
        if ($request->start_date && $request->end_date) {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $date_array = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
            $shipments = $shipments->whereBetween('derivery_date', $date_array);
        }
        if ($request->Upstart_date && $request->Upend_date) {
            $Upstart_date = Carbon::parse($request->Upstart_date);
            $Upend_date = Carbon::parse($request->Upend_date);
            // dd('test');
            $Update_array = array(
                'Upstart_date' => $Upstart_date,
                'Upend_date' => $Upend_date,
            );
            $shipments = $shipments->whereBetween('created_at', $Update_array);
        }
        if (!empty($client)) {
            $shipments = $shipments->whereIn('client_id', $client);
        }
        if ($branch_id) {
            $shipments = $shipments->where('branch_id', $branch_id);
        }
        if ($status) {
            $shipments = $shipments->where('status', $status);
        }
        $shipments = $shipments->latest()->take(20000)->get();
        $shipments->transform(function($shipment) {
            $shipment->order_id = $shipment->bar_code;
            return $shipment;
        });
        return $shipments;
    }
    public function ProdReport(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $email = $request->email;
        $status = $request->status;

        $date_array = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );

        if ($status == 'Dispatched') {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('dispatch_date', [$date_array])->where('client_email', 'LIKE', "%{$email}%")->take(15000)->get();
        } else {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('derivery_date', [$date_array])->where('client_email', 'LIKE', "%{$email}%")->where('status', $status)->take(15000)->get();
        }
    }

    public function paymentReport(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $date_array = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );

        if ($request->paid == 1) {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->where('paid', true)->take(15000)->get();
        } else {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->where('paid', false)->take(15000)->get();
        }
    }

    public function logsReport(Request $request)
    {
        return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $date_array = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );

        if ($request->paid == 1) {
            return Logs::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->where('paid', true)->take(15000)->get();
        } else {
            return Shipment::where('country_id', Auth::user()->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->where('paid', false)->take(15000)->get();
        }
    }
    public function countryReport(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $date_array = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );
        return Shipment::where('country_id', $request->country_id)->latest()->setEagerLoads([])->whereBetween('created_at', [$date_array])->get();
    }

    public function status_report(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $client = $request->client;

        $date_array = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        );
        $shipments = new Shipment;
        $shipments = $shipments->whereIn('status', $request->status);
        if (!empty($client)) {
            $shipments = $shipments->whereIn('client_id', $client);
        }
        if (Auth::user()->hasPermissionTo('filter by country') && $request->country) {
            $shipments = $shipments->withoutGlobalScope(ShipmentScope::class);
        }
        $shipments = $shipments->whereBetween('created_at', $date_array);
        $shipments = $shipments->get();
        return $shipments;
    }
}
