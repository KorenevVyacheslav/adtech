<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// маршрут регистрации и получения токена JWT для api
Route::post('/login', function () {
    $credentials = request(['email', 'password']);
    if (! $token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    return response()->json(['token' => $token]);
});

Route::get('/link/{offer_id}/{user_id}', [LinkController::class, 'edit'])->name('link.edit');   // маршрут обработки ссылок, переданные web-мастерам, система редиректор 

// маршруты вебмастера:
Route::group(['middleware'=>['jwt.auth','webmasterRole']], function () {
    Route::post('offers', [LinkController::class, 'getAllOfferByWebmaster']);      // маршрут возвращает все офферы, на которые подписан текущий вебмастер
    Route::post('offers/allowed', [LinkController::class, 'getAllOfferAllowed']);  // маршрут возвращает все офферы, на которые может быть подписан текущий вебмастер
    Route::post('offers/allowed/{id}', [LinkController::class, 'subscribeOffer']); // маршрут для подписки на доступный оффер 
});

