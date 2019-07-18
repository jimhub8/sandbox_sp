<?php

namespace App\Imports;

use App\Shipment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ShipmentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Shipment([
                "Order ID" => $row["Order ID"],
                "Name of The client" => $row["Name of The client"],
                "Address" => $row["Address"],
                "Postal Code" => $row["Postal Code"],
                "City" => $row["City"],
                "Region" => $row["Region"],
                "Phone" => $row["Phone"],
                "COD Amount " => $row["COD Amount "],
                "quantity" => $row["quantity"],
                "Sender Name" => $row["Sender Name"],
                "Sender Address" => $row["Sender Address"],
                "Sender mail" => $row["Sender mail"],
                "order date" => $row["order date"],
        ]);
    }
}
