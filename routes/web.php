<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\ChangeNickController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Webmaster\WebmasterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Advertiser\AdvertiserController;
use App\Http\Controllers\AjaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name ('welcome');

Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');  // маршрут смены пароля в личном кабинете
Route::post('change-name', [ChangeNickController::class, 'store'])->name('change.name');              // маршрут смены никнейма в личном кабинете
Route::get('/noactive', [HomeController::class, 'noactive'])->name ('noactive');                      // маршрут куда направляем отключенного пользователя

Auth::routes();

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Admin!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
Route::group(['prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {
    Route::get('workboard', [AdminController::class, 'index'])->name('admin.workboard');      // маршрут для вывода рабочего стола
    Route::post('/workboard', [AdminController::class, 'update'])->name('admin.update');      // маршрут для активации/отключения пользователя из рабочего стола администратора через AJAX
    Route::get('dashboard', [AdminController::class, 'dash'])->name('admin.dashboard');       // маршрут личного кабинета (смена никнейма и пароля)
    Route::get('workboard/show', [AdminController::class, 'show'])->name('admin.show');       // маршрут вывода статистики по офферам 
    Route::post('workboard/ajax', [AjaxController::class, 'adminData'])->name('admin.ajax');  // маршрут для запроса массива офферов вебмастера для статистики через AJAX
});
 

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Webmaster!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
Route::group(['prefix' => 'webmaster','namespace'=>'Webmaster','middleware'=>['auth','webmaster']], function () {
    Route::get('workboard', [WebmasterController::class, 'index'])->name('webmaster.workboard');             // маршрут для вывода рабочего стола
    Route::get('workboard/show', [WebmasterController::class, 'show'])->name('webmaster.show');              // маршрут вывода статистики по офферам 
    Route::post('/workboard/offer/{id}', [WebmasterController::class, 'update'])->name('webmaster.update');  // маршрут обработки подписки/отписки на оффер 
    Route::get('dashboard', [WebmasterController::class, 'dash'])->name('webmaster.dashboard');              // маршрут личного кабинета (смена никнейма и пароля)
    Route::post('workboard/ajax', [AjaxController::class, 'webmasterData'])->name('webmaster.ajax');         // маршрут для запроса массива офферов вебмастера для статистики через AJAX

});

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Advertiser!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
Route::group(['prefix' => 'advertiser','namespace'=>'Advertiser','middleware'=>['auth','advertiser']], function () {
    Route::get('workboard', [AdvertiserController::class, 'index'])->name('advertiser.workboard');          // маршрут для вывода рабочего стола
    Route::get('workboard/create', [AdvertiserController::class, 'create'])->name('advertiser.create');     // маршрут для вывода страницы создания оффера
    Route::post('workboard', [AdvertiserController::class, 'store'])->name('advertiser.store');             // маршрут для сохранения оффера  
    Route::get('workboard/info', function () {return view('advertiser.info');});                            // страница "оффер успешно создан" без контроллера
    Route::patch('/workboard', [AdvertiserController::class, 'update'])->name('advertiser.update');         // активирует/деактивирует оффер из рабочего столя рекламодателя черех AJAX
    Route::get('workboard/show', [AdvertiserController::class, 'show'])->name('advertiser.show');           // маршрут вывода статистики по офферам 
    Route::get('dashboard', [AdvertiserController::class, 'dash'])->name('advertiser.dashboard');           // маршрут личного кабинета (смена никнейма и пароля)         
    Route::post('workboard/ajax', [AjaxController::class, 'advertiserData'])->name('advertiser.ajax');      // маршрут для запроса массива офферов рекламодателя для статистики через AJAX
});
