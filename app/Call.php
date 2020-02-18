<?php

namespace App;

use App\Scopes\ShipmentScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    // protected $hidden = ['update_data'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function shipment()
    {
        return $this->belongsTo('App\Shipment', 'shipment_id')->withoutGlobalScope(ShipmentScope::class);
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
