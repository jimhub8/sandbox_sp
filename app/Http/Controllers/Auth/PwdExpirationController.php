<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PwdExpirationController extends Controller
{

    public function showPasswordExpirationForm(Request $request){
        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }
        return view('auth.passwordExpiration');
    }

    public function postPasswordExpiration(Request $request){
        // dd($request->all());
        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }

        $user = User::find($password_expired_id);
        if (!(Hash::check($request->get('current-password'), $user->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not match with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        if(strcmp($request->get('password_confirmation'), $request->get('new-password')) != 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New password and confirm password don't match");
        }
        // dd($request->all());


        $validatedData = $request->validate([
            'current-password' => 'required',
            // 'new-password' => 'required|string|min:6|confirmed',
        ]);
            // dd('test');

        //Change Password
        $user->password = bcrypt('password');
        // $user->password = bcrypt($request->get('new-password'));
        $user->save();

        //Update password updation timestamp
        $user->passwordSecurity->password_updated_at = Carbon::now();
        $user->passwordSecurity->save();

        return redirect('/login')->with("status","Password changed successfully, You can now login !");
    }
}
