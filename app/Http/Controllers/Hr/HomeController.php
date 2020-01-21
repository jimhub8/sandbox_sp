<?php

namespace App\Http\Controllers\Hr;

use Illuminate\Http\Request;
use Exception;
use App\User;
use Spatie\Permission\Models\Permission;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function hr()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        $user = Auth::user();
        $country = Country::find($user->country_id);
        // dd($country);
        $user->country_name = $country->country_name;
        // $users->transform(function ($user, $key) {
        //     $country = Country::find($user->country_id);
        //     $user->country_name = $country->name;
		// 	return $user;
        // });
        // dd(json_decode(json_encode((Auth::user()), false)));
        $auth_user = array_prepend($user->toArray(), $permissions, 'can');
        return view('hr/welcome', compact('auth_user'));
    }
    public function courierHome()
    {
        return redirect('/')->where('name', '[A-Za-z]+');
    }

    /**
     * Load homepage
     *
     * @param  Request $request
     * @return view
     */
    public function index(Request $request)
    {
        // return redirect('/login');
        if (Auth::check()) {
            return redirect('/courier');
        }
    }

}
