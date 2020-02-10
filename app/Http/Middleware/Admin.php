<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class Admin
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
        if($user->role != 'Peserta')
        {   
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
