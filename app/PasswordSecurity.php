<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordSecurity extends Model
{
    protected $guarded = [];


    protected $fillable = [
        'user_id',
        'password_expiry_days',
        'password_updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
