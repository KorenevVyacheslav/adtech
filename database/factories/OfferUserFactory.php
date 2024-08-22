<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OfferUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // распределяем вебмастеров офферам
    public function definition(): array
    {
        return [                                                
            'offer_id' => Offer::inRandomOrder()->first()->id, 
            'user_id' => User::inRandomOrder()->where('role', 'webmaster')->first()->id,
            
        ];
    }
}
