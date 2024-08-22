<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $redirectTo;

    public function __construct() {
        if (Auth::check() && Auth::user()->role == "admin") {
            $this->redirectTo = route("admin.dashboard");
        } elseif (Auth::check() && Auth::user()->role == "webmaster") {
            $this->redirectTo = route("webmaster.dashboard");
        } elseif (Auth::check() && Auth::user()->role == "advertiser") {
            $this->redirectTo = route("advertiser.dashboard");
        }
        $this->middleware("guest")->except("logout");
    }

}
