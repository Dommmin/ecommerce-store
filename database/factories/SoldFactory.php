<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SoldFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_variant_id' => ProductVariant::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'pcs' => $this->faker->numberBetween(1, 5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
