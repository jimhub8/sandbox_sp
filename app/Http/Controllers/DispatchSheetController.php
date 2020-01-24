<?php

namespace App\Http\Controllers;

use App\Exports\DispatchSheetExport;
use App\Shipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DispatchSheetController extends Controller
{
    public function export_dispatch(Request $request)
    {
        // return Excel::download(new DispatchSheetExport, 'dispatch.xlsx');

    }

    public function search_order($search)
    {
        // dd($search);

        $search = str_replace(' ', '', $search);
        return Shipment::where('bar_code', 'LIKE', "%{$search}%")->first();
    }
}
