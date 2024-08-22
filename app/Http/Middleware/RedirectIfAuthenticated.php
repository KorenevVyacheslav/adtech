<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {                     // guard 'web'
                return redirect(RouteServiceProvider::HOME);        // срабатывает, если ввести /login уже залогиненому пользователю
                                                                    // или чужой маршрут
            }
        }
        return $next($request);
    }








    // public function handle(Request $request, Closure $next, string ...$guards): Response 
    // {
    //     $guards = empty($guards) ? [null] : $guards;
       
    //     foreach ($guards as $guard) {

    //         if (Auth::guard($guard)->check()) {                  // не срабатывает на странице логина

    //             //dd (Auth::guard($guard));                      //web, срабатывает, когда аутентифицирован и пошел на /admin/dashboard

    //             if (Auth::user()->role == "admin") {
    //                 return redirect()->route('admin.dashboard');
    //             } 
    //             if (Auth::user()->role == "webmaster") {                           
    //                 return redirect()->route('webmaster.dashboard');
    //             }                               

    //                                                                             // этот надо удалить
    //             dd ('RouteServiceProvider::HOME in RedirectIfAuthenticated');  // сюда выйдет, если нет ролей, а пошел на /admin/dashboard
    //             return redirect(RouteServiceProvider::HOME);                    
 
 
    //         }
    //     }

    //     return $next($request);
    //  }


}
