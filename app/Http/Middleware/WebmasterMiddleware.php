<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class WebmasterMiddleware                   // класс допуска пользователя на маршруты с ролью webmaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (Auth::check() && Auth::user()->role == 'webmaster') {       // проверка аутентификации и авторизации

            if (Auth::user()->is_active) {                              // проверка активации пользователя
                return $next($request);
            } else return redirect()->route('noactive');                // отключенного пользователя направляем на маршрут noActive

        } else {
            // если нет прав на маршрут переход на роут login. 
            // Далее этот роут перехватит RedirectIfAuthenticated, в котором guard 'web', отправит на RouteServiceProvider::HOME
            return redirect()->route('login');   
        }
    }
}
