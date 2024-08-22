<?php

namespace App\Http\Controllers\Webmaster;

use App\Http\Controllers\Controller;
use App\Http\Service\OfferService;
use App\Models\Offer;
use App\Models\OfferUser;
use Auth;
use Illuminate\Support\Facades\Config;

class WebmasterController extends Controller        // класс вебмастера
{   
    // метод для страницы рабочего стола
    public function index(){    
        $offer= (Auth::user()->offers);                             // получаем коллекцию офферов текущего пользователя

       $offer_id = (new OfferUser)->getOfferIdCurrentUser ();       // получаем id офферов текущего пользователя

       $offer_allowed = (new Offer)->getActiveOffer();              // получаем коллекцию активных офферов 

       // получаем коллекцию, где нет офферов, на которые подписан текущий пользователь
       $offer_allowed = $offer_allowed->diff(Offer::whereIn('id', $offer_id)->get());  

       $key = substr(Config::get('app.key'), 7, 10);                    // обрезаем "base64:" из ключа приложения для получения ключа шифрования
       $user_idEncoded = base64_encode($key . Auth::user()->id);        // кодируем $user_id текущего web-мастера

       $offer_allowed=(new OfferService)->putDataInOffer($offer_allowed); // наполняем разрешенные офферы данными о количестве подписчиков, темами и ключе шифрования 

        $offer=(new OfferService)->putDataInOffer($offer);             // наполняем офферы, на которые уже подписан, данными о количестве подписчиков, темами и ключе шифрования 

        return view('webmaster.workboard', ['offer'=> $offer, 'offer_allowed'=> $offer_allowed, 'user_idEncoded'=> $user_idEncoded] );
    }

    // метод для страницы вывода статистики по офферам 
    public function show(){
        return view('webmaster.statistic');
    }

    // маршрут обработки подписки/отписки на оффер через рабочий стол вебмастера
    public function update($id){  
        if (request('subscribe'))  {                       //обработка кнопки подписи на оффер
            OfferUser::create([                            // в запросе name='subscribe'
                'offer_id' => $id,
                'user_id' => Auth::user()->id,
            ]);

            $offer = OfferUser::all();
            $offer->fresh();
            return redirect()->route('webmaster.workboard');
        }    
        elseif (request('unsubscribe'))  {                  //обработка кнопки отписки от оффера               
            (new OfferUser)->unsubscribeOfferById ($id);    // в запросе name='unsubscribe'
            return redirect()->route('webmaster.workboard');            
        }       
    }

    // метод возвращает страницу рабочего кабинета
    public function dash(){
      return view('webmaster.dashboard');
    }

}
