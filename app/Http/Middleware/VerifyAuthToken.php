<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Closure;

class VerifyAuthToken
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
        //  $token = $request->get('token');
        if ($request->has('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->get('token'));
        }
        return $next($request);
        // $tokenData = Token::where(['id' => $token])->first();
        // if (!$tokenData) {
        //     return redirect('/');
        // }

        // $user = $tokenData->user()->first();

        // if ($user) {
        //     Auth::loginUsingId($user->id);
        //     return $next($request);
        // } else {
        //     return redirect('/');
        // }
    }
}