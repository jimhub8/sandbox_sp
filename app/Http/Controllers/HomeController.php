<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Country;
use App\Events\MessageSent;
use App\PasswordSecurity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function courier()
    {
        $user = Auth::user();
        if (!$user->passwordSecurity) {
            $passwordSecurity = PasswordSecurity::create([
                'user_id' => $user->id,
                'password_expiry_days' => 1,
                'password_updated_at' => Carbon::now(),
            ]);
        }
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
        return view('welcome', compact('auth_user'));
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
        // dd($request->session()->all());

        return view('home');
        // return redirect('/login');
        // if (Auth::check()) {
        //     return redirect('/courier');
        // }
    }
    public function passport()
    {
        return view('passport/passport');
    }



    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = 'A new order just came in from <a href="/shipment/' . $user->id . '">' . $user->name . '</a>';
        // return (auth()->user());
		broadcast(new MessageSent(auth()->user(), $message));

        return ['status' => 'Message Sent!'];
    }
}
