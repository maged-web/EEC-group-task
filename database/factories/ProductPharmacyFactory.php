<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\Product;
use App\Models\ProductPharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPharmacy>
 */
class ProductPharmacyFactory extends Factory
{

    protected $model = ProductPharmacy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'pharmacy_id' => Pharmacy::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
