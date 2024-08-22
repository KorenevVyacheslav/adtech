<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Offer;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Sequence;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected static ?string $password;

    public function run(): void
    {
        //создаём администратора 
        // DB::table('users')->insert([
        //     'name' => 'admin', 'email' => 'admin@dom.ru', 'role' => 'admin', 'email_verified_at' => now(), 
        //     'password' => static::$password ??= Hash::make('12345678'), 
        //     'remember_token' => Str::random(3) 
        // ]);

        // создаём 10 вебмастеров
        // \App\Models\User::factory()
        // ->count(10)
        // ->sequence(fn (Sequence $sequence) => ['name' => 'webmaster'.$sequence->index+1])
        // ->sequence(fn (Sequence $sequence) => ['email' => 'webmaster'.(($sequence->index)+1).'@dom.ru'])
        // ->sequence(
        //     ['role' => 'webmaster',
        //     'password' => static::$password ??= Hash::make('12345678'),
        //     'remember_token' => Str::random(10),
        //     'remember_token' => Str::random(10)
        //     ])
        // ->create();

         // создаём 10 рекламодаталей
        // \App\Models\User::factory()
        // ->count(10)
        // ->sequence(fn (Sequence $sequence) => ['name' => 'advertiser'.$sequence->index+1])
        // ->sequence(fn (Sequence $sequence) => ['email' => 'advertiser'.(($sequence->index)+1).'@dom.ru'])
        // ->sequence(
        //     ['role' => 'advertiser',
        //     'password' => static::$password ??= Hash::make('12345678'),
        //     'remember_token' => Str::random(10),
        //     'remember_token' => Str::random(10)
        //     ])
        // ->create();

        //темы офферов
        // \App\Models\Topic::factory()
        // ->count(7)
        // ->sequence(
        //     ['title' => 'новости'],
        //     ['title' => 'музыка'],
        //     ['title' => 'криптовалюта'],
        //     ['title' => 'политика'],
        //     ['title' => 'экономика'],
        //     ['title' => 'акции'],
        //     ['title' => 'юмор'],
        // )
        // ->create();

        // офферы
      // \App\Models\Offer::factory(10)->create();


        // присваиваем каждому офферу создателя с ролью advertiser
        // \App\Models\OfferUser::factory()
        // ->count(10)
        // ->sequence(fn (Sequence $sequence) => ['offer_id' => $sequence->index+1])
        // ->state(new Sequence(
        //     fn () => ['user_id' => User::inRandomOrder()->where('role', 'advertiser')->first()->id],
        //     ))
        // ->create();

        //распределяем вебмастеров по офферам
        // \App\Models\OfferUser::factory(10)->create();
        
        // наполняем таблицу clicks. Выбираем только пользователей - webмастеров
        \App\Models\Click::factory(30)->create();
    }
}







        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // \App\Models\Click::factory()
        // ->count(10)
        // ->state(new Sequence(
        //     fn () => ['user_id' => User::inRandomOrder()->where('role', 'webmaster')->first()->id],
        //     ))
        // ->state(new Sequence(
        //     fn () => ['offer_id' => Offer::inRandomOrder()->first()->id],
        //     ))
        // ->create();  