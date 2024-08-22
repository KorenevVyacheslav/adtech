<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChangeNickController extends Controller           // класс смены никнейма
{

    public function __construct() {
        $this->middleware('auth');
    }

    // метод валидации и сохранения никнейма
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();
        $user->name = ($request->name);
        $user->save();
  
        return back()->with('success', 'Никнейм успешно изменён!');
    }
}
