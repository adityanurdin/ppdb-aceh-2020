<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Madrasah
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
        if($user->role == 'Operator Madrasah' || $user->role == 'Admin System')
        {   
            return $next($request);
        } else {
            return back();
        }
    }
}
