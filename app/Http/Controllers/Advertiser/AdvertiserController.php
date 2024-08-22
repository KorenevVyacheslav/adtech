<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Http\Service\OfferService;
use App\Models\Offer;
use App\Models\OfferUser;
use App\Models\Topic;
use Auth;


class AdvertiserController extends Controller           // класс рекламодателя
{

    public $offer;

    public function __construct()  {
        $this->offer=new Offer;
    }

    // метод для страницы рабочего стола
    public function index(){
       $offer= (Auth::user()->offers);                                  // получаем коллекцию офферов текущего рекламодателя
     
       $offer = (new OfferService)->putDataInOffer($offer);             // наполняем массив с офферами данными о количестве подписчиков и темами 

       $count_active = $offer->where('is_actived', '=' , true)->count();           // подсчет активных и неактивных офферов
       $count_nonactive = $offer->where('is_actived', '=' , false)->count();       // для надписей "Активные/неактивные" на странице
     
       return view('advertiser.workboard', ['offer' => $offer, 'count_active' => $count_active, 'count_nonactive' => $count_nonactive ], );
    }

    //метод активации/деактивации оффера из рабочего стола рекламодателя
    // для ответа по AJAX
    public function update(){        
        $offer = $this->offer->findOfferById(request('id'));                        // находим оффер по Id

        if (request('act') == 'diz') {    $data = ['is_actived' => false]; }        // отключение
        elseif (request('act') == 'act') $data = ['is_actived' => true];            // активация

        $offer->update($data);
        $offer=$offer->fresh();

        return response()->json();
    }

    //метод перенаправляет на страницу создания оффера
    //после нажатия кнопки создания оффера
    public function create(){
        $topic = Topic::all();
        return view('advertiser.create', ['topic' => $topic]);
    }

    //метод для создания оффера
    //после нажатия кнопки создания оффера
    public function store(){               
        $data=request()->validate ([                            // проверка ввода
        'title'=> 'required|unique:offers|alpha_dash',       
        'cpc'=> 'required|integer|min:1|max:100',
        'url_'=> 'required|unique:offers|url',
        ]);
 
        $data['topic_id'] = (new Topic)->getTopicIdByTitle(request('topic'));   // получение id темы по названию

        $offer_id = Offer::create($data)->id;                   // получаем id созданной записи для записи в таблицу offer_user

        OfferUser::create([                                    // запись в таблицу
              'offer_id' => $offer_id,
              'user_id' => Auth::user()->id,
          ]);

        return redirect('/advertiser/workboard/info');             //редирект на страницу "оффер успешно создан" без контроллера 
    }

    // метод вызова страницы статистики для рекламодателя
    public function show(){      
     return view('advertiser.statistic');
    }

    // метод вызова страницы личного кабинета для рекламодателя
    public function dash(){
        return view('advertiser.dashboard');
    }

}
