<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferUser extends Model               // модель соотношений пользователи-офферы
{
    use HasFactory;

    protected $table = 'offer_user';     

    protected $fillable = [
        'offer_id',
        'user_id',
    ];

    // метод возвращает массив id офферов текущего пользователя
    // вызывается из WebmasterController index() и LinkControllergetAllOfferAllowed()
    public function getOfferIdCurrentUser () { 
        $offer_id= OfferUser::where('user_id', Auth::user()->id)->get()->pluck('offer_id');  // массив id офферов, где подписан текущий вебмастер
        return $offer_id;
    }

    // метод отписки от оффера. Вызывается из метода update($id) WebmasterController
    public function unsubscribeOfferById ($id) { 
        OfferUser::where ('user_id', Auth::user()->id)
        ->where ('offer_id', $id)->delete();
    }
}
