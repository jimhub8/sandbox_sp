<?php

namespace App;

use App\Scopes\ClientScope;
use App\Scopes\ShipmentScope;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
// use Symfony\Component\EventDispatcher\Event;
class Shipment extends Model
{
    use SoftDeletes;
    public $with = ['products', 'statuses'];
    // use Searchable;
    /**
     * Get the index name for the model.
     *
     * @return string
     */
    // public function searchableAs()
    // {
    //     return 'client_name';
    // }

    public function products()
    {
        return $this->hasMany('App\Product', 'shipments_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function statuses()
    {
        return $this->hasMany('App\ShipmentStatus', 'shipment_id');
    }

    public function calls()
    {
        return $this->hasMany('App\Call', 'shipment_id');
    }

    public $fillable = [
        'client_name', 'client_phone', 'client_email', 'client_address', 'client_city',
        'assign_staff', 'airway_bill_no', 'shipment_type', 'payment', 'insuarance_status',
        'booking_date', 'derivery_date', 'bar_code', 'derivery_time', 'sender_name',
        'sender_phone', 'sender_address', 'sender_city', 'total_freight',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ShipmentScope);
        static::addGlobalScope(new ClientScope);
    }
}

