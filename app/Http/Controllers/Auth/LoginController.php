<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
        // protected $redirectTo = RouteServiceProvider::HOME; 
         
        // метод перенаправления сразу после авторизации:
        public function redirectTo()  {
            switch (auth()->user()->role) {
                case 'admin':
                    return route('admin.workboard');
        
                case 'webmaster':
                    return route('webmaster.workboard');
    
                case 'advertiser':
                    return route('advertiser.workboard');                    

                default:
                    auth()->logout();
                    return route('welcome');
            }
        }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()  {
 
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
