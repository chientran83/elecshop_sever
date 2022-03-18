<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class sliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->text(),
            'image_path' => 'https://i.ytimg.com/vi/8IM82rdy3Dc/maxresdefault.jpg',
            'status' => 1
        ];
    }
}
