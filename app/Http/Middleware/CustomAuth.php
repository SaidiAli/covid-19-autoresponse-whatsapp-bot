<?php

namespace App\Http\Middleware;

use Closure;

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
        if(!$this->validate($request)) {
            return redirect('login');
        }
        
        return $next($request);
    }

    public function validate($request) {
        if(empty($request->all())) {
            return false;
        }

        if ($request->input('username') == 'saidiali' and $request->input('password') == 'megamanxx') {
            return true;
        }
    }
}
