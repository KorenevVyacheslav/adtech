<?php

namespace App\Http\Controllers;

use App\Http\Service\OfferService;
use App\Models\Click;
use App\Models\Offer;
use App\Models\OfferUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Log;
use App\Models\User;

class LinkController extends Controller                 // класс системы-редиректора
{

    //метод обработки ссылки, на которую кликнет пользователь на сайте web-мастера
    // вызывается из маршрута api/link/{offer_id}/{user_id}
    public function edit($offer_idEncoded, $user_idEncoded){

        // дешифруем offer_id и user_id
        $offer_id = substr(base64_decode($offer_idEncoded), 10, 5);     // предполагаем, что в таблице offer максимум id=99999 
        $user_id = substr(base64_decode($user_idEncoded), 10, 5);       // предполагаем, что в таблице user максимум id=99999 

        $check_offer = OfferUser::where('user_id', $user_id)           // проверяем, что в ссылке указан вебмастер, который подписан
        ->where('offer_id', $offer_id)->get();                         // на данный оффер

        if ($check_offer->isEmpty()) {                                  // если вебмастер не подписан, 
            Click::create([                                             // то сохраняем клик со статусом is_legal=false
                'user_id' => $user_id,                                  // в таблице Click
                'offer_id' => $offer_id,
                'is_legal' => false,
            ]);
            return abort(404);                                          // если не подписан, то сбраcываем на 404  
        }                      
                                                                        
        Click::create([                                                // фиксируем факт перехода по ссылке 
            'user_id' => $user_id,                                     // записью в таблице Click                               
            'offer_id' => $offer_id,
            'is_legal' => true,
        ]);

        $url = Offer::find($offer_id)->url_;                           // получаем ссылку из оффера                        
        
        // фиксируем в логах факт перехода
        Log::info('переход на оффер '. $url. ' с сайта вебмастера '. User::find($user_id)->name );
        return redirect()->away($url);                                 // перенаправляем на внешний адрес
    }

    // метод возвращает все офферы, на которые подписан текущий вебмастер
    // вызывается из маршрута api/offers
    public function getAllOfferByWebmaster(){
        $offer= Auth::user()->offers;                                   // получаем все офферы текущего пользователя
        $offer = (new OfferService)->putDataInOfferApi ($offer);        // добавляем данные в массив офферов
        $offer['message'] = 'Офферы, на которые вы подписаны';  
        return response()->json($offer, 200);
    }

    // метод возвращает все офферы, на которые может быть подписан текущий вебмастер
    // вызывается из маршрута api/offers/allowed
    public function getAllOfferAllowed() {
        $offer_allowed = (new Offer)->getOfferAllowed();                                    // получаем все офферы все офферы, на которые может быть подписан текущий вебмастер
        $offer_allowed = (new OfferService)->putDataInOfferApi ($offer_allowed);            // добавляем данные в массив офферов 
                                                                                
        $offer_allowed['message'] = 'Офферы, на которые вы можете подписаться';
    
        return response()->json($offer_allowed, 200);
    }

    // метод подписки вебмастера на оффер
    // вызявается из маршрута api/offers/allowed/{id}
    public function subscribeOffer($id){
        if (!is_numeric($id)) { return response()->json(['message' => 'ID должно быть число'], 405); }      // проверяем, что id - число
        
        $offer_allowed = (new Offer)->getOfferAllowed();                                    // получаем все офферы, на которые может быть подписан текущий вебмастер   
        $offer_id= $offer_allowed->pluck('id')->toArray();    

        if(in_array($id, $offer_id))   {                                                    // создаём запись
            OfferUser::create([
            'offer_id' => $id,
            'user_id' => Auth::user()->id,
            ]);  
        }
        else return response()->json(['message' => 'вы ввели несуществующий оффер или уже на который подписаны'], 405);

        $key = substr(Config::get('app.key'), 7, 10);                    // обрезаем "base64:" из ключа приложения для получения ключа шифрования
        $user_idEncoded = base64_encode($key . Auth::user()->id);        // кодируем $user_id текущего web-мастера
        $offer_idEncoded = base64_encode($key . $id);                    // кодируем $offer_id текущего web-мастера
 
        $arr = [
            'message'=> 'Вы подписаны на оффер',
            'ваша cсылка на оффер'=> 'http://127.0.0.1:8000/api/link/'.$offer_idEncoded.'/'. $user_idEncoded,       
        ];
        return response()->json($arr, 200);
    }

}

