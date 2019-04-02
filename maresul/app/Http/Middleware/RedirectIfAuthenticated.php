<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) { //tratamento de erros caso usuario tenta acessar admin
            if($guard=='admin'){
                return redirect()->route('admin_home');
            }
            return redirect('/home');
        }

        return $next($request);
    }
}
