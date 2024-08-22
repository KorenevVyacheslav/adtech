<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller        // класс администратора
{   
    // метод возвращает всех пользователей из БД для отображения на рабочем столе
    public function index(){                                
        $users= (new User)->getAllUsers();
        return view('admin.workboard', ['users' => $users]);
    }

    // метод для страницы личного кабинета
    public function dash(){
        return view('admin.dashboard');
    }

    // метод активирует/отключает пользователя из рабочего стола администратора
    // вызывается по запросу AJAX
    public function update(){               
        $user=(new User)->findUserById(request('id'));                          // находим пользователя по Id

        if (request('act') == 'diz') {  $data = ['is_active' => false]; }       // отключение
        elseif (request('act') == 'act') $data = ['is_active' => true];         // активация

        $user->update($data);                                                   
        $user->fresh();
        return response()->json();                                                                                     
    } 

    // метод для страницы вывода статистики по офферам 
    public function show(){
        return view('admin.statistic');
    }
 
}
