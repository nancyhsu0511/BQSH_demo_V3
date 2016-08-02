<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Tmanager
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
		if( !Auth::check() ) {
			return redirect('/');
		} else {
			$user = Auth::user();
			if($user->hasRole('teacher')) {
                return $next($request);
            } else {
                return redirect('/home');
            }
		}
    }
}
