<?php

namespace App\Http\Middleware;

use Closure;

class SetTimezone
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
        //\DB::statement("SET time_zone = 'Europe/London'");

        return $next($request);
    }
}