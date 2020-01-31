<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateSecretRequest;
use App\PasswordSecurity;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Socialite;
use Cache;

class LoginController extends Controller
{
    /*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/courier';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:clients')->except('logout');
    }

    /**
     * Redirect the user to the Social media authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from Social media.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        $userSocialite = Socialite::driver($service)->user();
        $findUser = User::where('email', $userSocialite->email)->first();
        if ($findUser) {
            // return $findUser;
            // Auth::login($findUser);
            return redirect('/courier');
        } else {
            $user = new User;
            $user->name = $userSocialite->name;
            $user->email = $userSocialite->email;
            // $user->profile = $userSocialite->avatar;
            // return $user;
            // $user->status = '0';
            $user->password = Hash::make('password');
            $user->save();
            Auth::login($userSocialite->email);
            return redirect('/');
        }
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // protected function credentials(Request $request)
    // {
    //     $credentials = $request->only($this->username(), 'password');
    //     $credentials['status'] = 1;
    //     return $credentials;
    // }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function getValidateToken()
    {

        if (session('2fa:user:id')) {
            return view('2fa/validate');
        }

        return redirect('login');
    }

    /**
     *
     * @param  App\Http\Requests\ValidateSecretRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postValidateToken(ValidateSecretRequest $request)
    {

        //get user id and create cache key
        $userId = $request->session()->pull('2fa:user:id');
        $key    = $userId . ':' . $request->otp;

        //use cache to store token to blacklist
        Cache::add($key, true, 4);

        //login and redirect user
        Auth::loginUsingId($userId);

        return redirect()->intended($this->redirectTo);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->passwordSecurity) {

            $request->session()->forget('password_expired_id');

            $password_updated_at = $user->passwordSecurity->password_updated_at;
            $password_expiry_days = $user->passwordSecurity->password_expiry_days;
            $password_expiry_at = Carbon::parse($password_updated_at)->addDays($password_expiry_days);
            if ($password_expiry_at->lessThan(Carbon::now())) {
                $request->session()->put('password_expired_id', $user->id);
                auth()->logout();
                return redirect('/passwordExpiration')->with("info", "Your Password has expired, Please change your password. The new password will expire in 24 hours");
            }
        } else {
            $passwordSecurity = PasswordSecurity::create([
                'user_id' => $user->id,
                'password_expiry_days' => 1,
                'password_updated_at' => Carbon::now(),
            ]);
        }

        if ($user->google2fa_secret) {
            Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);
            return redirect('2fa/validate');
        }
        return redirect()->intended($this->redirectTo);
        // }
        // dd($user->passwordSecurity);

        return redirect()->intended($this->redirectPath());
    }
}
