<?php

namespace App;

use App\Scopes\ClientScope;
use App\Scopes\ShipmentScope;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
// use Symfony\Component\EventDispatcher\Event;
class Shipment extends Model
{
    use SoftDeletes;
    public $with = ['products', 'statuses'];
    public $timestamps = true;

    // protected $casts = [
    //     'driver' => 'integer',
    // ];
    public $fillable = [
        'user_id', 'sender_name', 'sender_email', 'sender_address', 'sender_city', 'sender_phone', 'vendor', 'client_name', 'client_email', 'client_address', 'client_postal_code', 'client_region', 'client_city', 'client_phone', 'client_id', 'assign_staff', 'airway_bill_no', 'bar_code', 'amount_ordered', 'shipment_id', 'paid', 'status', 'container', 'driver', 'payment', 'shipment_type', 'insuarance_status', 'from', 'to', 'charges', 'booking_date', 'derivery_date', 'delivered_on', 'derivery_time', 'remark', 'branch_id', 'derivery_status', 'order_id', 'to_city', 'from_city', 'weight', 'receiver_name', 'sub_total', 'cod_amount', 'speciial_instruction', 'lat_to', 'lat', 'lng', 'location', 'lng_to', 'printed', 'description',  'country', 'printReceipt', 'deleted_at', 'created_at', 'updated_at', 'country_id', 'driver_id', 'assign_date', 'return_date', 'receiver_id', 'distance', 'sticker', 'pickup_at', 'printed_at', 'pickup_id', 'dispatch_date',
    ];
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

    public function shipment_status()
    {
        return $this->hasMany(ShipmentUpdate::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ShipmentScope);
        static::addGlobalScope(new ClientScope);
    }
}
