<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller       // класс смены пароля         
{

    public function __construct()  {
        $this->middleware('auth');
    }

    // метод валидации и сохранения нового пароля
    public function store(Request $request) {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
          ]);

          $user = Auth::user();
  
          if (!Hash::check($request->current_password, $user->password)) {
              return back()->with('error', 'Неверный текущий пароль!');
          }
  
          $user->password = Hash::make($request->password);

          $user->save();
  
          return back()->with('success', 'Пароль успешно изменён');
    }

}
