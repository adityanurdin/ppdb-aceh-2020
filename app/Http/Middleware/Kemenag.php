<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Kemenag
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
        if($user->role == 'Operator Kemenag' || $user->role == 'Admin System')
        {   
            return $next($request);
        } else {
            return back();
        }
    }
}
