<?php

namespace App\Http\Controllers;

use App\Http\Service\OfferService;
use App\Http\Service\PeriodService;
use App\Models\Click;
use App\Models\Offer;
use App\Models\User;
use Auth;

class AjaxController extends Controller       // класс для работы с AJAX запросами
{

    public $offer;
    public $user;

    public function __construct()  {
        $this->offer=new Offer;
        $this->user=new User;
    }

    // метод возвращает массив по AJAX для пользователя admin для страницы статистики по офферам
    public function adminData(){
        $period = PeriodService::getPeriod(request ('period'));    //получаем дату в формате Y-m-d H:i:s за вычетом заданного периода    

        $offers =  $this->offer->getAllOffer();                    // получаем коллекцию офферов

        $user_id= $this->user->getWebmasterId();                   // получаем массив вебместеров 

        $offers = (new OfferService)->putDataInOfferAdmin($offers,  $period, $user_id);  // наполняем массив с офферами данными о кликах и ссылках 
      
        return response()->json(['offers' => $offers]);
    }

    // метод возвращает массив по AJAX для рекламодателя для страницы статистики по офферам
    public function advertiserData() {
        $period = PeriodService::getPeriod(request ('period'));    //получаем дату в формате Y-m-d H:i:s за вычетом заданного периода  

        $offers= Auth::user()->offers;                            // получаем коллекцию офферов, созданных текущим пользователем 
      
        foreach ($offers as $item)  {                 
            $item->clicks= Click::where('offer_id', $item->id)      // вычисляем число кликов 
            ->whereDate('created_at', '>' , $period)                // за заданный период
            ->get()
            ->count();
        }

        return response()->json(['offers' => $offers]);
    }

    // метод возвращает массив по AJAX для вебмастера для страницы статистики по офферам
    public function webmasterData() {
        $period = PeriodService::getPeriod(request ('period'));       //получаем дату в формате Y-m-d H:i:s за вычетом заданного периода
      
        $offers= Auth::user()->offers;                                // получаем коллекцию офферов, на которые подписан текущий пользователь           
           
        foreach ($offers as $item)  {                                 
            $item->clicks= Click::where('offer_id', $item->id)        // вычисляем число кликов 
            ->whereDate('created_at', '>' , $period)                  // за заданный период
            ->get()
            ->count();
        }
     
        return response()->json(['offers' => $offers]);
    }

}
