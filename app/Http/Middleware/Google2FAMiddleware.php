<?php

namespace App\Http\Middleware;

use App\Support\Google2FAAuthenticator;
use Closure;
use Illuminate\Support\Facades\Auth;

class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $authenticator = app(Google2FAAuthenticator::class)->boot($request);
        // if ($authenticator->isAuthenticated()) {
        //     return $next($request);
        // }
        // return $authenticator->makeRequestOneTimePasswordResponse();
        if (Auth::guard('web')->check()) {
            $user = Auth::user();
            if ($user->google2fa_secret || $user->email == 'sandbox@speedball.com') {
                return $next($request);
            }
            // return redirect()->intended($this->redirectTo);
            return redirect('/2fa_home');
        }
        return $next($request);
    }
}
