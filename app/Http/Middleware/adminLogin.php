<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( session('admin_login') && session('admin_email') ) {
            return redirect()->back();
        }

        return $next($request);
    }
}
