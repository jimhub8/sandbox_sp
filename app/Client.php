<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Client extends Authenticatable
{
    use Notifiable, SoftDeletes;
    use HasRoles, HasApiTokens;
    protected $guard_name = 'clients';
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'city', 'country', 'zipcode', 'branch', 'profile', 'branch_id', 'country_id', 'start_day', 'end_day', 'show_on', 'status', 'active', 'verifyToken', 'activation_token',
    ];
    protected $appends = ['is_client', 'is_admin'];


    public function scopeUserid($query)
    {
        if (Auth::guard('clients')->check()) {
            return $query->where('id', Auth::guard('clients')->id());
        } elseif (Auth::check()) {
            if (Auth::user()->hasRole('Client')) {
                return $query->where('user_id', Auth::id());
            }
        }
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get all user permissions.
     *
     * @return bool
     */
    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }

    public function getIsAdminAttribute()
    {
        return false;
    }

    public function getIsClientAttribute()
    {
        return true;
    }

    public function country_()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
}
