<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CustomAuth
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
        if(is_null($request->cookie('user_'.env('USER_NAME')))) {
            return redirect('/login');
        }

        return $next($request);
    }
}
