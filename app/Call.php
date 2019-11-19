<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    public function users()
    {
        return $this->hasMany('App\User', 'user_id');
    }
    public function shipment()
    {
        return $this->belongsTo('App\Shipment', 'shipment_id');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('D d M Y ');
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('D d M Y ');
    }
}
