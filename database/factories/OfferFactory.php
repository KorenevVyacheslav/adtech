<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Offer::class;
    

    public function definition(): array
    {

        $faker=Faker::create('en_US');

        return [
            'title'=>$faker->domainWord(),                              
            'cpc' => random_int(1, 10),                           
            'url_'=> 'https://'.$faker->unique()->domainName(),                                                          
           // 'topic_id' => Topic::get()->random()->id,  
           'is_actived' => (bool)random_int(0, 1),
           'topic_id' => Topic::inRandomOrder()->first()->id,  
            //'created_at' => now(),                          
        ];
    }
}
