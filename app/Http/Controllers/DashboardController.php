<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Shipment;
use Auth;
use DB;
use App\Country;
use App\Scopes\ShipmentScope;

class DashboardController extends Controller
{
    public function getChartData(Request $request)
    {
        // return $request->all();
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->groupBy('date');
            if ($request->country) {
                $shipments = $shipments->where('country_id', $request->country);
            }
            if ($request->year_f) {
                $shipments = $shipments->whereYear('created_at', '=', (int)$request->year_f);
            }
            $shipments = $shipments->get();
        }
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

    public function getChartScheduled(Request $request)
    {
        // return $request->all();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                ->where('status', 'Scheduled')
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                ->where('status', 'Scheduled')
                ->get();
        }

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

    public function getChartDelivered(Request $request)
    {
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                ->where('status', 'Delivered')
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                ->where('status', 'Delivered')
                ->get();
        }

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

    public function getChartCancled(Request $request)
    {
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = Shipment::select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                ->where('status', 'Cancelled')
                ->get();
        } else {
            // DB::enableQueryLog(); // Enable query log
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                ->where('status', 'Cancelled')
                ->get();
                // dd(DB::getQueryLog()); // Show results of log

        }

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

    public function getCountCount(Request $request)
    {
        $countries = ['name' => 'Kenya', 'name' => 'Uganda', 'name' => 'Tanzania'];
        foreach ($countries as $country) {
            // return $country;
            $tanzania = Shipment::where('country', 'Tanzania')->count();
            $uganda = Shipment::where('country', 'Uganda')->count();
            $kenya = Shipment::where('country', 'Kenya')->count();
        }
        return $country = array(
            'Kenya' => $kenya,
            'Tanzania' => $tanzania,
            'Uganda' => $uganda,
        );
    }


    public function getBranchCount(Request $request)
    {
        // return $request->all();
        if (empty($request->country)) {
            $branches = Branch::setEagerLoads([])->where('country_id', Auth::user()->country_id)->get();
        } else {
            $branches = Branch::setEagerLoads([])->where('country_id', $request->country)->get();
        }
        $branch_count = [];
        if (empty($request->country)) {
            foreach ($branches as $key => $branch) {
                // return $branch->id;
                // $branch_count[] = Shipment::where('branch_id', $branch->id)->count();
                $branch_count[] = array(
                    'name' => $branch->branch_name,
                    'id' => $key,
                    'count' => Shipment::where('branch_id', $branch->id)->count(),
                );
            }
        } else {
            foreach ($branches as $key => $branch) {
                $branch_count[] = array(
                    'name' => $branch->branch_name,
                    'id' => $key,
                    'count' => Shipment::withoutGlobalScopes()->where('branch_id', $branch->id)->where('country_id', $request->country)->count(),
                );
            }
        }
        return $branch_count;
    }

    public function getChartBranch(Request $request)
    {
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                // ->where('branch_id', Auth::id())
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                // ->where('branch_id', Auth::id())
                ->get();
        }

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

    public function getChartCount(Request $request)
    {
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                // ->where('branch_id', Auth::id())
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                // ->where('branch_id', Auth::id())
                ->get();
        }

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

    public function getBranchShipments(Request $request)
    {
        $branches = Branch::all();
        $A_branch = [];
        foreach ($branches as $branch) {
            if (empty($request->country)) {
                $shipmen_ts = DB::table('shipments')
                    ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date, branch_id'))
                    ->orderBy('id', 'asc')
                    ->whereYear('created_at', '=', date("Y"))
                    ->groupBy('date')
                    // ->where('branch_id', $branch->id)
                    ->get();
            } else {
                $shipmen_ts = Shipment::withoutGlobalScopes()
                    ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date, branch_id'))
                    ->orderBy('id', 'asc')
                    ->whereYear('created_at', '=', date("Y"))
                    ->groupBy('date')
                    ->where('country_id', $request->country)
                    // ->where('branch_id', $branch->id)
                    ->get();
            }

            // $shipments = Shipment::where('branch_id', $branch->id)->count();
            // json_decode(json_encode($branch), true);
            $A_branch[] = array_prepend(json_decode(json_encode($shipmen_ts), true), $branch->branch_name, 'name');
        }
        return $shipmen_ts;
    }


    public function getCountryhipments(Request $request)
    {
        $countries = Country::setEagerLoads([])->get();
        $country_count = [];
        foreach ($countries as $key => $country) {
            // return $country->id;
            // $country_count[] = Shipment::where('country_id', $country->id)->count();
            $country_count[] = array(
                'name' => $country->country_name,
                'id' => $key,
                'count' => Shipment::withoutGlobalScopes()->whereYear('created_at', '=', date("Y"))->where('country_id', $country->id)->count(),
            );
        }
        return $country_count;
    }

    public function getChartCountry(Request $request)
    {
        // return Shipment::take(100)->get();
        if (empty($request->country)) {
            $shipments = DB::table('shipments')
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', date("Y"))
                ->groupBy('date')
                // ->where('country_id', )
                ->get();
        } else {
            $shipments = Shipment::withoutGlobalScopes()
                ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
                ->orderBy('id', 'asc')
                ->whereYear('created_at', '=', $request->year_f)
                ->groupBy('date')
                ->where('country_id', $request->country)
                // ->where('country_id', )
                ->get();
        }

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

    public function countDelivered(Request $request)
    {
        // return $request->all();
        if (empty($request->country)) {
            return Shipment::whereYear('created_at', '=', date("Y"))->where('status', 'Delivered')->count();
        } else {
            return Shipment::withoutGlobalScopes()->whereYear('created_at', '=', $request->year_f)->where('country_id', $request->country)->where('status', 'Delivered')->count();
        }
    }

    public function countPending(Request $request)
    {
        // return Shipment::count();
        if (empty($request->country)) {
            return Shipment::whereYear('created_at', '=', date("Y"))->where('status', '!=', 'Delivered')->where('status', '!=', 'Cancelled')->count();
        } else {
            return Shipment::withoutGlobalScopes()->whereYear('created_at', '=', $request->year_f)->where('country_id', $request->country)->where('status', '!=', 'Delivered')->where('status', '!=', 'Cancelled')->count();
        }
    }



    public function countCountShipments(Request $request)
    {
        // return Shipment::count();
        if (empty($request->country)) {
            return Shipment::whereYear('created_at', '=', date("Y"))->count();
        } else {
            return Shipment::withoutGlobalScopes()->where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->count();
        }
    }

    public function countOrders(Request $request)
    {
        return Shipment::whereYear('created_at', '=', $request->year_f)->count();
    }
}
