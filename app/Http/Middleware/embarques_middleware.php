<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class embarques_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role == 'Administrador') {
            return $next($request);
        }

<<<<<<< HEAD
            if (Auth::user()->role == 'Embarques') {
                return $next($request);
            } else {
                return redirect()->route('dashboard');
            }
        
=======
        if (Auth::user()->role == 'Facturista') {
            return $next($request);
        }
        
        



        if (Auth::user()->role == 'Embarques') {
            return $next($request);
        } else {
            return redirect()->route('dashboard');
        }
>>>>>>> master
    }
}
