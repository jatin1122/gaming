<?php

namespace App\Http\Middleware;

use Closure;

class BlockIfBanned
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
        if ($request->user()->isBanned()) {
            return redirect()->route('banned');
        }

        return $next($request);
    }
}
