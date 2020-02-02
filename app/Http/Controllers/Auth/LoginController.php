<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateSecretRequest;
use App\models\Sms;
use App\models\Token;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        // dd($request->session()->get('token_id'));
        // if ($user->passwordSecurity) {

        //     $request->session()->forget('password_expired_id');

        //     $password_updated_at = $user->passwordSecurity->password_updated_at;
        //     $password_expiry_days = $user->passwordSecurity->password_expiry_days;
        //     $password_expiry_at = Carbon::parse($password_updated_at)->addDays($password_expiry_days);
        //     if ($password_expiry_at->lessThan(Carbon::now())) {
        //         $request->session()->put('password_expired_id', $user->id);
        //         auth()->logout();
        //         return redirect('/passwordExpiration')->with("info", "Your Password has expired, Please change your password. The new password will expire in 24 hours");
        //     }
        // } else {
        //     $passwordSecurity = PasswordSecurity::create([
        //         'user_id' => $user->id,
        //         'password_expiry_days' => 1,
        //         'password_updated_at' => Carbon::now(),
        //     ]);
        // }
        if ($request->verify == 'sms') {
            $min = pow(10, 4);
            $max = $min * 10 - 1;
            $code = mt_rand($min, $max);

            // dd($code);
            $token = Token::create([
                'user_id' => $user->id
            ]);
            // $request->session()->forget('token_id');
            // session(['token_id' => $user->id]);
            $africas_talking = new Sms;
            $phone = $user->phone;
            $code =  $token->code;
            $code = substr($code, 0, -1);

            // dd($code);
            $africas_talking->verify($phone, $code);

            Auth::logout();
            $request->session()->put('token_id', $user->id);
            $request->session()->put('user_id', $user->id);
            $request->session()->put('remember', $request->get('remember'));
            return redirect('code');
        } else {
            if ($user->google2fa_secret) {
                Auth::logout();
                $request->session()->put('2fa:user:id', $user->id);
                return redirect('2fa/validate');
            }
        }
        // return redirect()->intended($this->redirectTo);
    }


    /**
     * Show second factor form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showCodeForm()
    {
        // $token = Token::create([
        //     'user_id' => $user->id
        // ]);
        if (!session()->has("token_id")) {
            return redirect("login");
        }

        return view("2fa.code");
    }

    /**
     * Store and verify user second factor.
     */
    public function storeCodeForm(Request $request)
    {
        // dd($request->session()->get('token_id'));
        // throttle for too many attempts
        // if (!session()->has("token_id", "user_id")) {
        //     return redirect("login");
        // }

        $token = Token::where('user_id', session()->get("token_id"))->latest()->first();
        // dd(session()->get("token_id"), $token);
        // dd(
        //     !$token,
        //     !$token->isValid(),
        //     $request->code !== $token->code,
        //     (int) session()->get("user_id") !== $token->user->id
        // );
        if (
            !$token ||
            !$token->isValid() ||
            $request->code !== $token->code ||
            (int) session()->get("user_id") !== $token->user->id
        ) {
            return redirect("code")->withErrors(["Invalid token"]);
        }

        // $token->used = true;
        // $token->save();
        $token->delete();
        $this->guard()->login($token->user, session()->get('remember', false));

        session()->forget('token_id', 'user_id', 'remember');

        return redirect()->intended($this->redirectTo);
        // return redirect('courier');
    }
}
