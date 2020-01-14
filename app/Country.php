<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasOne('App\User', 'country_id');
    }
    public function rider()
    {
        return $this->hasOne('App\models\Rider', 'country_id');
    }
    public function client()
    {
        return $this->hasOne('App\Client', 'country_id');
    }
    public function shipments()
    {
        return $this->hasMany('App\Shipment', 'branch_id');
    }
    public function branches()
    {
        return $this->hasMany('App\Branch', 'country_id');
    }
}
