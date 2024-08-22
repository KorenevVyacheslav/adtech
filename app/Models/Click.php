<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model           // модель фиксации переходов по ссылке
{
    use HasFactory;

    const UPDATED_AT = null; // Disable updated_at handling

    protected $table = 'clicks';     
    
    protected $fillable = [
        'user_id',
        'offer_id',
        'is_legal',
    ];


}
