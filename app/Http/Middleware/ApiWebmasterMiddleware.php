<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiWebmasterMiddleware         // класс допуска пользователя на маршруты api с ролью webmaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
         if (Auth::user()->role == 'webmaster') {                          // проверка роли

            if (Auth::user()->is_active) {                                 // проверка активации пользователя
               return $next($request);
            } else return response()->json(['message' => 'Ваша учетная запись отключена. Обратитесь к администратору'], 403);    // сообщение отключенного пользователя
         }

         return response()->json(['message' => 'Вы не вебмастер. Запрос отклонён'], 403);       // сообщение для пользователя с ролью невебмастера
 }







}
