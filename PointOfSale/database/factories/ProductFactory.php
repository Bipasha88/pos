<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
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
            'name' => $this->faker->name(),
            'code' => rand(1000, 9999),
            'product_category_id' => rand(1, 5),
            'retail_price' => rand(100, 10000),
            'whole_sale_price' => rand(100, 10000),
            'business_id' => 36,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
