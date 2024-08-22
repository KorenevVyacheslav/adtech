<?php

namespace App\Http\Service;

use App\Models\Click;
use App\Models\OfferUser;
use App\Models\Topic;
use Illuminate\Support\Facades\Config;

class OfferService                                                          // сервис для наполнения массива офферов                                              
{                                                                           // для разных ролей
    

    // метод перебирает массив с офферами и добавляет данные  
    // о легальных кликах, выданных ссылках, о нелегальных кликах
    // для администратора. Вызывается из AjaxController adminData()
    public function putDataInOfferAdmin ($offers, $period, $user_id){                

        foreach ($offers as $item)  {                      
            $item->clicks= Click::where('offer_id', $item->id)                  // получаем число кликов 
            ->where ('is_legal', true)                                          // только легальные клики
            ->whereDate('created_at', '>' , $period)                            // за заданный период
            ->get()->count();

            $item->refs= OfferUser::where('offer_id', $item->id)               // получаем число выданных ссылок по каждому офферу 
            ->whereIn('user_id',  $user_id)                                    // вебмастерам
            ->whereDate('created_at', '>' , $period)                           // за заданный период
            ->get()->count();

            $item->illegalClicks= Click::where('offer_id', $item->id)           // получаем число кликов
            ->where ('is_legal', false)                                         // только нелегальные клики
            ->whereDate('created_at', '>' , $period)                            // за заданный период
            ->get()->count();
        } 
    return $offers;
    }

    // метод перебирает массив с офферами и добавляет данные  
    // о числе подписчиков, темы оффера и ключа шифрования
    // Вызывается из AdvertiserController index() и WebmasterController index()
    public function putDataInOffer ($offer){

        $key = substr(Config::get('app.key'), 7, 10);                           // обрезаем "base64:" из ключа приложения для получения ключа шифрования
        foreach ($offer as $item)  { 
            $item->count = OfferUser::where('offer_id', $item->id)->get()->count() - 1;     // находим число подписчиков и уменьшаем на 1,
            $item->topic = Topic::where('id', $item->topic_id)->first()->title;             // т.к. один из них рекламодатель

            $item->offer_idEncoded = base64_encode($key . $item->id);                       // кодируем $offer_id и добавляем к каждому офферу зашифрованный offer_id
        }                                                                                   // используется только вебмастером
        return $offer;
    }

    // метод перебирает массив с офферами и добавляет данные  
    // о числе подписчиков, темы оффера, заменяет названия
    // удаляет метки pivot, created_at, updated_at
    // Вызывается из LinkController getAllOfferByWebmaster() и getAllOfferAllowed()
    public function putDataInOfferApi ($offer){

        foreach ($offer as $item)  { 
            $item->count = OfferUser::where('offer_id', $item->id)->get()->count() - 1;           // находим число подписчиков и уменьшаем на 1,
            $item['подписчиков'] = $item['count']; unset($item['count']);
            $item->topic = Topic::where('id', $item->topic_id)->first()->title;                   
            unset($item['created_at']); unset($item['updated_at']);
            unset($item['topic_id']);
            $item['цена за переход, руб'] = $item['cpc'];   unset($item['cpc']);
            unset ($item['pivot']);
        } 
         return $offer;
    }
}
