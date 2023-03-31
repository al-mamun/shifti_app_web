<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'specification' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween($min = 200, $max = 999999),
            'discount_percent' => $this->faker->numberBetween($min = 0, $max = 50),
            'slug' => $this->faker->slug,
            'status' => 1,
            'stock' => $this->faker->numberBetween($min = 0, $max = 50),
            'slug_id' => $this->faker->unique()->numberBetween(110001, 99999999999),
            'feature_photo' => $this->faker->image('public/images/uploads/products', 800, 800, 'cats', false),
        ];
    }
}
