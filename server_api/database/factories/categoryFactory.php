<?php

namespace Database\Factories;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;

class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = category::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->text()
        ];
    }
}
