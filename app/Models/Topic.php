<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model                   // модель тем офферов
{
    use HasFactory;
    public $timestamps = false;

    // метод возвращает id темы по её названию
    // вызывается из AdvertiserController update()
    public function getTopicIdByTitle($title) {
        return Topic::where('title', $title)->first()->id; 
    }

}
