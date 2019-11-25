<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Shipment;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function getPermissions()
    {
        return Permission::all();
    }

    public function getUsersCount(Request $request)
    {
        if (empty($request->country)) {
            return User::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->count();
        } else {
            return User::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->count();
        }
    }

    public function getShipmentsCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->count();
        } else {
            return Shipment::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->count();
        }
    }


    public function getDashCount(Request $request)
    {
        return Shipment::count();
    }

    public function getCanceledCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->where('status', 'Cancelled')->count();
        } else {
            return Shipment::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->where('status', 'Cancelled')->count();
        }
    }

// Dashboard
    public function delayedShipmentCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('status', 'Delayed')->count();
        } else {
            return Shipment::where('status', 'Delayed')->count();
        }
    }

    public function scheduledShipmentCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->where('status', 'Scheduled')->count();
        } else {
            return Shipment::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->where('status', 'Scheduled')->count();
        }
    }

    public function deriveredShipmentCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->where('status', 'Derivered')->count();
        } else {
            return Shipment::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->where('status', 'Derivered')->count();
        }
    }


    public function dispatchedShipmentCount(Request $request)
    {
        if (empty($request->country)) {
            return Shipment::where('country_id', Auth::user()->country_id)->whereYear('created_at', '=', date("Y"))->where('status', 'Dispatched')->count();
        } else {
            return Shipment::where('country_id', $request->country)->whereYear('created_at', '=', $request->year_f)->where('status', 'Dispatched')->count();
        }
    }
}
