<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use tpaksu\LaravelOTPLogin\OneTimePassword;

class CheckPhoneVerified
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
        $user = Auth::user();

        if ($user && $user->is_phone_verified === 1) {
            Session::put('otp_service_bypass', true);
            return $next($request);
        }
        if (Auth::check()) {
            $otp = OneTimePassword::whereUserId($user->id)->where("status", "=", "verified")->first();
            if ($otp) {
                $user->update(['is_phone_verified' => 1]);
            }
        }

        return $next($request);
    }
}