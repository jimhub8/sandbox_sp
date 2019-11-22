<?php

namespace App\Exports;

use App\Shipment;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DispatchSheetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd('test');
        return new Collection([
            [1, 2, 3],
            [4, 5, 6]
        ]);
        // return User::all();
        // dd(Shipment::setEagerLoads([])->take()->get());
    }
}
