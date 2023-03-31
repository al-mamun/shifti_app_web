<?php

namespace Database\Factories;

use App\Models\ProductFAQ;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFAQFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductFAQ::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'qus' => $this->faker->sentence,
            'ans' => $this->faker->paragraph,
            'status' => 1,
            'product_id' =>  $this->faker->numberBetween($min = 81, $max = 598),
        ];
    }
}
