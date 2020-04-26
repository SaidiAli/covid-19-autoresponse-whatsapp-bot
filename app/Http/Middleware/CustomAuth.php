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
        if(is_null($request->cookie('user_saidi'))) {
            return redirect('/login');
        }

        return $next($request);
    }

    public function fetchCredentials($request){
        return User::firstWhere('name', $request->input('name'));
    }

}
