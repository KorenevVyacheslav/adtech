<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;


class AdminMiddleware               // класс допуска пользователя на маршруты с ролью admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        } else {
            // если нет прав на маршрут переход на роут login. 
            //Далее этот роут перехватит RedirectIfAuthenticated, в котором guard 'web', отправит на RouteServiceProvider::HOME
            return redirect()->route('login');            
        }
    }
    
}
