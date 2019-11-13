<?php

namespace App\Http\Controllers;

use App\Shipment;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function delivery_count()
    {
        $date_arr = [];
        return Shipment::where('delivered_on', $date_arr)->count();
    }
}
