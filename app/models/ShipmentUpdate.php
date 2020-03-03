<?php

namespace App\models;

use App\Branch;
use App\Shipment;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ShipmentUpdate extends Model
{
    public $with = ['user', 'shipment'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
