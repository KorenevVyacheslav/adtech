<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{

    // метод возвращает страницу выключенного пользователя
    public function noactive() {
        $admin=User::where('role', 'admin')->first();
        return view('noactive', ['admin' => $admin]);
    }

}
