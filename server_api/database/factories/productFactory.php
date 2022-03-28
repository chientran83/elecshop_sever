<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = product::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'current_price' => rand(1000,9000),
            'origin_price' => rand(1000,7000),
            'previous_price' => rand(1000,7000),
            'image_path' => 'https://cdn.tgdd.vn/Products/Images/42/274153/iphone-13-pro-max-xanh-la-090322-093249-600x600.jpg',
            'ram' => rand(100,1000),
            'desc' => $this->faker->text(),
            'isOnSale' => rand(0,1),
            'quantity' => rand(0,100),
            'user_id' => rand(0,10),
        ];
    }
}
