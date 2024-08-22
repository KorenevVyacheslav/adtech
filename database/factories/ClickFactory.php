<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Click>
 */
class ClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker=Faker::create('en_US');

        return [
                'user_id' => User::inRandomOrder()->where('role', 'webmaster')->first()->id,
                'offer_id' => Offer::inRandomOrder()->first()->id,
                'is_legal' => (bool)random_int(0, 1), 
                'created_at'=>$faker->dateTimeBetween($startDate = '-6 month',$endDate = 'now'),
        ];
    }
}
