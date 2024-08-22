<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Offer extends Model           // модель офферов
{
    use HasFactory;

    protected $table = 'offers';            

    protected $fillable = [
        'title',
        'cpc',
        'url_',
        'is_actived',
        'topic_id',
    ];

    // возвращает тему оффера. Один оффер - одна тема. 
    public function topic(): BelongsTo {
       return $this->belongsTo(Topic::class, 'topic_id');      
    }

    // возвращает пользователей оффера. Один оффер - много пользователей.
    public function users() {
       return $this->belongsToMany(User::class);               
    }

    //метод возвращает все офферы
    // вызывается из AjaxController adminData()
    public function getAllOffer() {
        return DB::table('offers')->get();
    }

    // метод возвращает оффера по id
    // вызывается из AdvertiserController update()
    public function findOfferById($id){
       return  Offer::find($id);
    }

    // метод возвращает только активные офферы
    // вызывается из WebmasterController index() и LinkController getAllOfferAllowed()
    public function getActiveOffer() {
       return Offer::where('is_actived', true)->get();
    }

    // метод возвращает все офферы, на которые может быть подписан текущий вебмастер 
    // вызывается из LinkController getAllOfferAllowed()
    public function getOfferAllowed() {
        $offer_id = (new OfferUser)->getOfferIdCurrentUser ();           // получаем массив id офферов текущего пользователя
        $offer_allowed = (new Offer)->getActiveOffer();                  // получаем коллекцию активных офферов  
        $offer_allowed = $offer_allowed->diff(Offer::whereIn('id', $offer_id)->get());      // получаем коллекцию, где нет офферов, на которые подписан текущий пользователь 
   
        return $offer_allowed ;
    }

}
