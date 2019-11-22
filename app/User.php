<?php

namespace App;

use App\Notifications\verifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class User extends Authenticatable
{
	use Notifiable, SoftDeletes;
	use HasRoles, HasApiTokens;
	public $with = ['roles'];
	protected $guard_name = 'web';
    protected $appends = ['is_client', 'is_admin'];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'verifyToken', 'status',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/**
	 * The roles that belong to the user.
	 */
	public function country_()
	{
		return $this->belongsTo('App\Country', 'country_id');
	}

	public function branch()
	{
		return $this->belongsTo('App\Branch');
	}

	public function verified()
	{
		return $this->verifyToken === null;
	}

	public function sendVerificationEmail()
	{
		$this->notify(new verifyEmail($this));
	}

	public function documents()
	{
		return $this->hasMany('App\Attachment', 'client_id');
    }

	public function calls()
	{
		return $this->hasMany('App\Call');
	}

	public function shipStatus()
	{
		return $this->hasMany('App\ShipmentStatus', 'user_id');
	}

    /**
 * A user can have many messages
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
 public function messages()
 {
   return $this->hasMany(Message::class);
 }

	/**
	 * Get all user permissions.
	 *
	 * @return bool
	 */
	public function getAllPermissionsAttribute()
	{
		return $this->getAllPermissions();
    }

    public function getIsClientAttribute()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Client')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getIsAdminAttribute()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
