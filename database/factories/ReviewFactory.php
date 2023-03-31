<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'star'   =>$this->faker->numberBetween($min = 1, $max = 5),
           'review' =>$this->faker->paragraph,
           'user_id'   =>1,
           'product_id'=>$this->faker->numberBetween($min = 81, $max = 598),
           'status'=>1,

        ];
    }
}
