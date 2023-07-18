<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class programador_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
<<<<<<< HEAD
=======

>>>>>>> master
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

<<<<<<< HEAD
        if (Auth::user()->role == 'Administrador') {
            return $next($request);

            if (Auth::user()->role == 'Supervisor producciÃ³n') {
                return $next($request);
            }
            if (Auth::user()->role == 'Programador') {
                return $next($request);
            } else {
                return redirect()->route('dashboard');
            }
=======
        $user = Auth::user();
        $allowedRoles = ['Administrador', 'Supervisor producci¨®n', 'Programador'];

        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        } else {
            return redirect()->route('dashboard');
>>>>>>> master
        }
    }
}
