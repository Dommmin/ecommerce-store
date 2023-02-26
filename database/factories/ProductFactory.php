<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::pluck('id')->random(),
            'name' => $this->faker->name(),
            'description' => $this->faker->realTextBetween(100, 1000),
            'is_public' => $this->faker->boolean(),
            'created_by' => $this->faker->randomNumber(),
            'updated_by' => $this->faker->randomNumber(),
            'deleted_by' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'brand_id' => Brand::pluck('id')->random(),
        ];
    }
}
