<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rider extends Model
{
    use SoftDeletes;	/**
    * The roles that belong to the user.
    */
   public function country_()
   {
       return $this->belongsTo('App\Country', 'country_id');
   }
}
