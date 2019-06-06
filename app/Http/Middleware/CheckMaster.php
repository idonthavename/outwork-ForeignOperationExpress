<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMaster
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
        $uid = Auth::id();
        if (!Auth::check() || $uid > 1){
            return abort(404);
        }
        $request->uid = $uid;
        return $next($request);
    }
}
