<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject            // модель пользователей
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';     

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // возвращает офферы пользоватлея. Один пользователь - много офферов.
    public function offers() {
        return $this->belongsToMany(Offer::class);
    }

    // метод возвращает массив id всех вебмастеров 
    // вызывается из AjaxController adminData()
    public function getWebmasterId(){
        return User::where('role', 'webmaster')->get()->pluck('id');  
    }

    // метод возвращает всех пользователей
    // вызывается из AdminController index()
    public function getAllUsers(){
        return  User::paginate(10);
    }   

    // метод возвращает пользователя по id
    // вызывается из AdminController index()
    public function findUserById($id){
        return  User::find($id);
    }

    // метод возвращает ключ JWT
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    // метод возвращает пользовательские данные c JWT
    public function getJWTCustomClaims() {
        return [];
    }

}
