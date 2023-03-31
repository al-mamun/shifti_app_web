<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_name' => $this->faker->word(),
            'icon' => $this->faker->image('public/images/uploads/category_icon', 800, 800, 'cats', false),
            'level' => $this->faker->numberBetween($min = 0, $max = 5),
            'parent' => $this->faker->numberBetween($min = 1, $max = 10),
            'slug' => $this->faker->slug,
            'slug_id' => $this->faker->unique()->numberBetween(5, 100),
            'status' => 1,
        ];
    }
}
