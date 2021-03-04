<?php

namespace App\Http\Middleware;

use Closure;

class BlockIfFullBan
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
        if ($request->user()->hasFullBan()) {
            return redirect()->route('banned');
        }

        return $next($request);
    }
}
