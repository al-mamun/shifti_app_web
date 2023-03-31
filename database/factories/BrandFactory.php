<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand_name'=> $this->faker->city(),
            'slug'=> $this->faker->slug(),
            'slug_id'=> $this->faker->unique()->numberBetween(1000011, 1000510),
            'logo' => $this->faker->image('public/images/uploads/brand_logo/', 800, 800, 'cats', false),
            'status'=>1
        ];
    }
}
